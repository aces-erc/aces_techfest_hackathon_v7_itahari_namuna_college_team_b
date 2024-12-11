<?php
include_once 'config/db.php'; // Include database connection
session_start();

// Handle login logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']); // Could be phone or email
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        try {
            $stmt = $db->prepare("SELECT user_id, full_name, password FROM users WHERE email = :username OR phone = :username");
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Store user details in the session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['full_name'] = $user['full_name'];

                // Redirect to the dashboard
                header("Location: view/dashboard.php");
                exit();
            } else {
                $error = "Invalid phone number or password.";
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in both fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-md">
            <?php if (!empty($error)): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <p><?php echo $error; ?></p>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-xl shadow-md border border-gray-100 px-8 py-10">
                <h2 class="text-center text-3xl font-bold text-gray-800 mb-6">Sign In</h2>
                <form method="POST" action="" class="space-y-6">
                    <div>
                        <label class="text-gray-700 text-sm mb-2 block">Phone Number or Email</label>
                        <input name="username" type="text" required
                            class="w-full text-gray-800 border border-gray-300 px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter your phone number or email" />
                    </div>
                    <div>
                        <label class="text-gray-700 text-sm mb-2 block">Password</label>
                        <input name="password" type="password" required
                            class="w-full text-gray-800 border border-gray-300 px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter your password" />
                    </div>
                    <div class="text-right">
                        <a href="javascript:void(0);" class="text-blue-600 text-sm hover:underline">
                            Forgot password?
                        </a>
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full py-3 text-sm font-semibold rounded-md text-white bg-blue-600 hover:bg-blue-700 transition duration-300">
                            Log in
                        </button>
                    </div>
                    <p class="text-sm text-center text-gray-600">
                        Don't have an account?
                        <a href="signup.php" class="text-blue-600 font-semibold hover:underline ml-1">
                            Register here
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>