<?php
// Include database and session
include_once '../config/db.php';
include_once '../includes/session.php';

// Khalti API secret key
$khalti_secret_key = "test_secret_key_7da14cd84ffe4be2b188ba28c84cb52f";

// Get token and amount from query string
$order_id = $_GET['order_id'] ?? null;
$token = $_GET['token'] ?? null;
$amount = $_GET['amount'] ?? null;

if (!$order_id || !$token || !$amount) {
    die("Invalid parameters.");
}

// Confirm payment with Khalti API
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://khalti.com/api/v2/payment/verify/",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Key " . $khalti_secret_key,
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        "token" => $token,
        "amount" => $amount,
    ]),
]);

$response = curl_exec($curl);
$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($http_status === 200) {
    $response_data = json_decode($response, true);

    // Update the order in the database
    $stmt = $db->prepare("
        UPDATE orders 
        SET transaction_tx = :transaction_tx, status = 'paid' 
        WHERE id = :order_id AND user_id = :user_id
    ");
    $stmt->execute([
        ':transaction_tx' => $response_data['idx'],
        ':order_id' => $order_id,
        ':user_id' => $_SESSION['user_id'],
    ]);

    echo "<p>Payment successful! Transaction ID: " . $response_data['idx'] . "</p>";
    echo "<a href='dashboard.php' class='text-blue-500'>Go to Dashboard</a>";
} else {
    echo "<p>Payment verification failed. Please try again.</p>";
}
?>
