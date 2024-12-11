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
                header("Location: dashboard.php");
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
<body>
    <div class="font-[sans-serif]">
        <div class="grid lg:grid-cols-2 gap-4 max-lg:gap-12 bg-gradient-to-r from-blue-500 to-blue-700 px-8 py-12 h-[320px]">
            <div>
                <a href="javascript:void(0)"><img
                    src="https://readymadeui.com/readymadeui-white.svg" alt="logo" class='w-40' />
                </a>
                <div class="max-w-lg mt-16 max-lg:hidden">
                    <h3 class="text-3xl font-bold text-white">Sign in</h3>
                    <p class="text-sm mt-4 text-white">
                        Embark on a seamless journey as you sign in to your account.
                        Unlock a realm of opportunities and possibilities that await you.
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-xl sm:px-6 px-4 py-8 max-w-md w-full h-max shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] max-lg:mx-auto">
                <?php if (!empty($error)): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                        <p><?php echo $error; ?></p>
                    </div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="mb-8">
                        <h3 class="text-3xl font-extrabold text-gray-800">Sign in</h3>
                    </div>
                    <div class="mt-4">
                        <label class="text-gray-800 text-sm mb-2 block">Phone Number or Email</label>
                        <div class="relative flex items-center">
                            <input name="username" type="text" required
                                class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-md outline-blue-600"
                                placeholder="Enter your phone number or email" />
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb"
                                class="w-[18px] h-[18px] absolute right-4" viewBox="0 0 24 24">
                                <circle cx="10" cy="7" r="6"></circle>
                                <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="text-gray-800 text-sm mb-2 block">Password</label>
                        <div class="relative flex items-center">
                            <input name="password" type="password" required
                                class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-md outline-blue-600"
                                placeholder="Enter your password" />
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb"
                                class="w-[18px] h-[18px] absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                                <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="javascript:void(0);" class="text-blue-600 text-sm font-semibold hover:underline">
                            Forgot your password?
                        </a>
                    </div>

                    <div class="mt-8">
                        <button type="submit"
                            class="w-full shadow-xl py-3 px-6 text-sm font-semibold rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                            Log in
                        </button>
                    </div>
                    <p class="text-sm mt-8 text-center text-gray-800">
                        Don't have an account?
                        <a href="signup.php" class="text-blue-600 font-semibold hover:underline ml-1 whitespace-nowrap">
                            Register here
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
