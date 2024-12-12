<?php
// Include database and session
include_once '../config/db.php';
include_once '../includes/session.php';

// Khalti API keys
$khalti_public_key = "test_public_key_09903c0b42f0481e9f450aab5b14300b";
$khalti_secret_key = "test_secret_key_7da14cd84ffe4be2b188ba28c84cb52f";

// Get order ID from query string
$order_id = $_GET['order_id'] ?? null;

if (!$order_id) {
    die("Invalid order ID.");
}

// Fetch order details
$stmt = $db->prepare("SELECT * FROM orders WHERE id = :order_id AND user_id = :user_id");
$stmt->execute([':order_id' => $order_id, ':user_id' => $_SESSION['user_id']]);
$order = $stmt->fetch();

if (!$order) {
    die("Order not found.");
}

// Order details
$order_amount = $order['payment_amount'] * 100; // Amount in paisa
$order_identity = "Order#" . $order['id'];
$order_name = "Pro Plan Subscription";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redirecting to Khalti</title>
    <script src="https://khalti.com/static/khalti-checkout.js"></script>
</head>
<body>
<script>
    const config = {
        publicKey: "<?php echo $khalti_public_key; ?>",
        productIdentity: "<?php echo $order_identity; ?>",
        productName: "<?php echo $order_name; ?>",
        productUrl: "http://localhost/aces_techfest_hackathon_v7_itahari_namuna_college_team_b/view/khalti.php?order_id=<?php echo $order_id; ?>",
        eventHandler: {
            onSuccess(payload) {
                console.log("Payment Successful:", payload);
                // Redirect to the verification endpoint
                window.location.href = "khalti_verify.php?order_id=<?php echo $order_id; ?>&token=" + payload.token + "&amount=<?php echo $order_amount; ?>";
            },
            onError(error) {
                console.error("Khalti Error:", error);
                alert("Something went wrong. Please try again.");
            },
            onClose() {
                console.log("Khalti popup closed.");
                alert("You closed the payment popup.");
            },
        },
    };

    const checkout = new KhaltiCheckout(config);

    // Automatically open the Khalti popup on page load
    window.onload = () => {
        checkout.show({ amount: <?php echo $order_amount; ?> }); // Amount in paisa
    };
</script>
</body>
</html>
