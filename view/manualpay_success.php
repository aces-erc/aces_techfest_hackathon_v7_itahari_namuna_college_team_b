<?php
// Include session to check if user is logged in
include_once '../includes/session.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex items-center justify-center">
    <div class="max-w-lg w-full bg-white shadow-md rounded-lg p-8 text-center">
        <h2 class="text-2xl font-semibold text-green-600 mb-4">Payment Submitted!</h2>
        <p class="text-gray-700 mb-6">
            Thank you for submitting your payment details. Our team will verify your payment soon.
        </p>
        <a href="dashboard.php" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-full transition">
            Go to Dashboard
        </a>
    </div>
</body>
</html>
