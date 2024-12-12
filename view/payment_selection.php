<?php
$order_id = $_GET['order_id'] ?? null;
$price = $_GET['price'] ?? null;

if (!$order_id || !$price) {
    die("Invalid order or price.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Method</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
<div class="max-w-md mx-auto bg-white p-6 rounded shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Choose Payment Method</h2>
    <form action="khalti.php" method="GET" class="space-y-4">
        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
        <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">

        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Pay with Khalti</button>
    </form>
    <form action="bank_payment.php" method="GET" class="mt-4">
        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
        <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">

        <button type="submit" class="w-full px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Pay with Bank</button>
    </form>
</div>
</body>
</html>

