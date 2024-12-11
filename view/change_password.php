<?php
include_once '../config/db.php';
include_once '../includes/session.php';
require '../vendor/autoload.php'; // Ensure Composer autoload works
use PragmaRX\Google2FA\Google2FA; // Google2FA library

// Initialize Google2FA
$google2fa = new Google2FA();

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch the Google Authenticator secret for the user
try {
    $stmt = $db->prepare("SELECT google_auth_secret FROM users WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !$user['google_auth_secret']) {
        die("Error: Google Authenticator is not set up for this account.");
    }

    $google_auth_secret = $user['google_auth_secret'];
} catch (PDOException $e) {
    die("Error fetching Google Authentication data: " . $e->getMessage());
}

// Handle password change request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $otp = $_POST['otp'];

    // Verify OTP
    $isValidOtp = $google2fa->verifyKey($google_auth_secret, $otp);
    if (!$isValidOtp) {
        die("Invalid OTP. Please try again.");
    }

    // Check if new passwords match
    if ($new_password !== $confirm_password) {
        die("New passwords do not match.");
    }

    // Fetch the current password hash from the database
    try {
        $stmt = $db->prepare("SELECT password FROM users WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($current_password, $user['password'])) {
            die("Current password is incorrect.");
        }
    } catch (PDOException $e) {
        die("Error verifying current password: " . $e->getMessage());
    }

    // Update the password
    try {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt = $db->prepare("UPDATE users SET password = :password WHERE user_id = :user_id");
        $stmt->execute([
            ':password' => $hashed_password,
            ':user_id' => $user_id,
        ]);
        echo "Password updated successfully.";
    } catch (PDOException $e) {
        die("Error updating password: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4 text-center">Change Password</h2>
        <form method="POST" class="space-y-4">
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                <input type="password" id="current_password" name="current_password" class="w-full px-4 py-2 border rounded focus:outline-none" required>
            </div>
            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                <input type="password" id="new_password" name="new_password" class="w-full px-4 py-2 border rounded focus:outline-none" required>
            </div>
            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="w-full px-4 py-2 border rounded focus:outline-none" required>
            </div>
            <div>
                <label for="otp" class="block text-sm font-medium text-gray-700">Google Authenticator OTP</label>
                <input type="text" id="otp" name="otp" class="w-full px-4 py-2 border rounded focus:outline-none" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">Change Password</button>
        </form>
    </div>
</body>
</html>
