<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        accent: {
                            50: '#fef6f9',
                            100: '#fdeff5',
                            200: '#facfe1',
                            300: '#f59fca',
                            400: '#f062b5',
                            500: '#db2777',
                            600: '#b71d63',
                            700: '#931850',
                            800: '#73123e',
                            900: '#5a0e31',
                        }
                    }
                }
            }
        };
    </script>
</head>
<?php include "../includes/sidebar.php"; ?>
<body class="h-full bg-primary-50">
    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-primary-800">Change your password</h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Ensure your account is using a strong and unique password for security.
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-6 shadow-lg rounded-lg sm:px-10">
                <form class="space-y-6" action="#" method="POST">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">
                            Current Password
                        </label>
                        <input id="current_password" name="current_password" type="password" required
                               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                               placeholder="••••••••">
                    </div>

                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700">
                            New Password
                        </label>
                        <input id="new_password" name="new_password" type="password" required
                               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                               placeholder="••••••••">
                    </div>

                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700">
                            Confirm New Password
                        </label>
                        <input id="confirm_password" name="confirm_password" type="password" required
                               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                               placeholder="••••••••">
                    </div>

                    <div>
                        <label for="otp" class="block text-sm font-medium text-gray-700">
                            Google Authenticator OTP
                        </label>
                        <input id="otp" name="otp" type="text" required
                               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                               placeholder="Enter OTP">
                    </div>

                    <div>
                        <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-150 ease-in-out">
                            Change Password
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">
                                Need help?
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <a href="#"
                           class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Forgot Password
                        </a>
                        <a href="#"
                           class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
