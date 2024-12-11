<?php
// Include session management and other dependencies
include 'includes/session.php'; // Include session check
include 'includes/sidebar.php'; // Include header
include 'config/db.php'; // Include PDO connection
require 'vendor/autoload.php'; // Ensure Composer autoload works
use PragmaRX\Google2FA\Google2FA; // Google2FA library

// Initialize Google2FA
$google2fa = new Google2FA();

$user_id = $_SESSION['user_id']; // Fetch the user ID from the session

// Check if the user has a Google Authenticator secret key
$sql = "SELECT google_auth_secret FROM users WHERE user_id = :user_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

$google_auth_secret = $user_data['google_auth_secret'] ?? null; // Fetch secret key from database

if ($google_auth_secret === null) {
    // Generate a new secret key
    $google_auth_secret = $google2fa->generateSecretKey();

    // Save the secret key to the database
    $sql_update = "UPDATE users SET google_auth_secret = :google_auth_secret WHERE user_id = :user_id";
    $stmt_update = $db->prepare($sql_update);
    $stmt_update->bindParam(':google_auth_secret', $google_auth_secret, PDO::PARAM_STR);
    $stmt_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if (!$stmt_update->execute()) {
        die("Error storing Google Authentication secret key.");
    }
}

$company_name = "Fitnepal"; // Company name for QR code
$qr_code_url = $google2fa->getQRCodeUrl($company_name, "user_{$user_id}", $google_auth_secret);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Authentication Setup</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> <!-- jQuery library -->
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script> <!-- QRCode library -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .auth-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        .btn {
            background-color: #2563eb;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #1d4ed8;
        }
        .error {
            color: #dc2626;
            font-weight: bold;
        }
        .success {
            color: #16a34a;
            font-weight: bold;
        }
    </style>
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert("Secret key copied to clipboard!");
            }).catch(err => {
                alert("Failed to copy text: " + err);
            });
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="auth-container">
        <h2 class="text-2xl font-bold mb-4 text-center">Google Authentication Setup</h2>
        <p class="text-gray-600 mb-6 text-center">Scan the QR code with Google Authenticator, then enter the generated OTP below:</p>
        
        <?php if (isset($qr_code_url)): ?>
        <div class="flex justify-center mb-6">
            <div id="qrcode" class="bg-gray-100 p-4 rounded"></div>
        </div>
        <script type="text/javascript">
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                text: "<?php echo $qr_code_url; ?>",
                width: 200,
                height: 200,
            });
        </script>
        <div class="text-center mb-6">
            <p class="text-gray-700">Your secret key: 
                <strong class="text-gray-900"><?php echo htmlspecialchars($google_auth_secret); ?></strong>
            </p>
            <button class="btn" 
                onclick="copyToClipboard('<?php echo htmlspecialchars($google_auth_secret); ?>')">Copy Secret Key</button>
        </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="space-y-4">
            <div>
                <label for="otp" class="block text-gray-700 font-medium">One-Time Password (OTP):</label>
                <input type="text" id="otp" name="otp" required
                    class="w-full px-4 py-2 border rounded shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <button type="submit" 
                class="btn w-full">Verify OTP</button>
        </form>
        
        <?php
        // Handling OTP verification
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["otp"])) {
            $otp = $_POST["otp"];
            $isValid = $google2fa->verifyKey($google_auth_secret, $otp); // Verify OTP
            
            if ($isValid) {
                echo "<p class='mt-4 text-center success'>Google Authentication setup successfully!</p>"; // Success message
            } else {
                echo "<p class='mt-4 text-center error'>Invalid OTP. Please try again.</p>"; // Error message
            }
        }
        ?>
    </div>
</body>
</html>

