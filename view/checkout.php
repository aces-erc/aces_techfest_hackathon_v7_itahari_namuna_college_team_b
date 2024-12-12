<?php
// Include database and session
include_once '../config/db.php';
include_once '../includes/session.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT full_name FROM users WHERE user_id = :user_id");
$stmt->execute([':user_id' => $user_id]);
$user = $stmt->fetch();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plan = $_POST['plan'] ?? '';
    $price = $_POST['price'] ?? 0;
    $payment_method = $_POST['payment_method'] ?? '';

    if ($payment_method === 'Bank' || $payment_method === 'Khalti') {
        // Insert order into the database
        $stmt = $db->prepare("
            INSERT INTO orders (user_id, full_name, payment_method, payment_amount, status) 
            VALUES (:user_id, :full_name, :payment_method, :payment_amount, 'unpaid')
        ");
        $stmt->execute([
            ':user_id' => $user_id,
            ':full_name' => $user['full_name'],
            ':payment_method' => $payment_method,
            ':payment_amount' => $price,
        ]);

        // Redirect to payment page
        if ($payment_method === 'Khalti') {
            header("Location: khalti.php?order_id=" . $db->lastInsertId());
            exit();
        } else {
            header("Location: manualpay.php?order_id=" . $db->lastInsertId());
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="max-w-3xl mx-auto mt-12 p-8 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold text-gray-800">Checkout</h2>
    <p class="mt-4 text-gray-600">Choose your payment method for the Pro plan (Rs. 100).</p>

    <form action="" method="POST" class="mt-6">
        <input type="hidden" name="plan" value="Pro">
        <input type="hidden" name="price" value="100">

        <div class="space-y-4">
            <label class="block">
                <input type="radio" name="payment_method" value="Khalti" required>
                <span class="ml-2">Khalti</span>
            </label>
            <label class="block">
                <input type="radio" name="payment_method" value="Bank" required>
                <span class="ml-2">Bank Payment</span>
            </label>
        </div>

        <button type="submit" class="mt-6 w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
            Proceed to Payment
        </button>
    </form>
</div>
</body>
</html>
