<?php
include_once '../config/db.php';
include_once '../includes/session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex items-center justify-center">
    <div class="max-w-lg w-full bg-white shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Manual Bank Payment</h2>
        <div class="mb-4">
            <h3 class="font-semibold text-gray-700">Bank Details</h3>
            <p><strong>Bank Name:</strong> ABC Bank</p>
            <p><strong>Account Name:</strong> FitNepal Pvt. Ltd.</p>
            <p><strong>Branch:</strong> Kathmandu</p>
            <p><strong>Amount:</strong> NPR 100.00</p>
        </div>
        <form id="manualPaymentForm" method="POST" action="process_manualpay.php">
            <div class="mb-4">
                <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" id="full_name" name="full_name" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
            </div>
            <div class="mb-4">
                <label for="payee_account_number" class="block text-sm font-medium text-gray-700">Payee Account Number</label>
                <input type="text" id="payee_account_number" name="payee_account_number" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
            </div>
            <div class="mb-4">
                <label for="receipt_id" class="block text-sm font-medium text-gray-700">Receipt ID</label>
                <input type="text" id="receipt_id" name="receipt_id" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
            </div>
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount (NPR)</label>
                <input type="number" id="amount" name="amount" value="100" readonly
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 bg-gray-200">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition">
                I Paid
            </button>
        </form>
    </div>
</body>
</html>
