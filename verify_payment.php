<?php
require_once 'vendor/autoload.php';
use Xentira\KhaltiSdk\Khalti;

// Load Khalti configuration
$config = require 'config/khalti_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the Khalti payment token from the request
    $requestBody = json_decode(file_get_contents('php://input'), true);
    $token = $requestBody['token'];
    $amount = $requestBody['amount'];

    // Initialize the Khalti client
    $khalti = new Khalti($config['secret_key']);

    try {
        // Verify the payment
        $response = $khalti->paymentVerification($token, $amount);

        // Check the response
        if ($response['state']['name'] === 'Completed') {
            // Payment was successful
            echo json_encode(['success' => true, 'message' => 'Payment verified successfully.']);
        } else {
            // Payment verification failed
            echo json_encode(['success' => false, 'message' => 'Payment verification failed.']);
        }
    } catch (Exception $e) {
        // Handle errors
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
