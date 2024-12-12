<?php
// Include your database and session
include_once '../config/db.php';
include_once '../includes/session.php';

// Autoload the Twilio PHP SDK
require_once '../vendor/autoload.php'; // Update with the correct path to autoload.php

use Twilio\Rest\Client;

// Twilio credentials
$sid = "ACba494322e03e6d0db251c7ec1a1b09d1";
$token = "a05160deb493d06c62e87d1f9d217be4"; // Replace with your Auth Token
$twilioPhoneNumber = "+13203356186"; // Replace with your Twilio number

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$userId = $_SESSION['user_id']; // Get logged-in user's ID
$today = date('Y-m-d'); // Get today's date

try {
    // Fetch the user's workout status and phone number
    $stmt = $db->prepare("
        SELECT u.full_name, u.phone, wc.status 
        FROM users u
        LEFT JOIN user_workout_calendar wc 
        ON u.user_id = wc.user_id AND wc.day = :today
        WHERE u.user_id = :user_id AND u.phone IS NOT NULL
    ");
    $stmt->execute([
        ':user_id' => $userId,
        ':today' => $today,
    ]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User data not found or phone number missing.");
    }

    $fullName = $user['full_name'];
    $phoneNumber = $user['phone'];
    $status = $user['status'];

    // Send SMS only if the user hasn't worked out today
    if ($status === null || $status === 'notworkout') {
        // Format phone number (ensure international format if not already)
        if (!preg_match('/^\+/', $phoneNumber)) {
            $phoneNumber = '+977' . preg_replace('/\D/', '', $phoneNumber); // Assuming Nepal (+977)
        }

        // Create a Twilio client
        $twilio = new Client($sid, $token);

        // Send SMS
        $message = $twilio->messages->create(
            $phoneNumber, // To
            [
                'from' => $twilioPhoneNumber,
                'body' => "{$fullName}, did you do your workout today? Stay active!",
            ]
        );

        echo "Message sent to {$fullName} at {$phoneNumber}. SID: " . $message->sid . "\n";
    } else {
        echo "{$fullName} already worked out today or status is updated.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

