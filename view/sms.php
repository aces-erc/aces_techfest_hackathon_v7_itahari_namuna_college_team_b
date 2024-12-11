<?php
// Include your database and session
include_once '../config/db.php';
include_once '../includes/session.php';

// Autoload the Twilio PHP SDK
require_once '../vendor/autoload.php';

use Twilio\Rest\Client;

// Twilio credentials
$sid = "ACba494322e03e6d0db251c7ec1a1b09d1"; // Replace with your SID
$token = "a40d42546469f725c2c14e5c0cb080e5"; // Replace with your Auth Token
$twilioPhoneNumber = "+13203356186"; // Replace with your Twilio number

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$userId = $_SESSION['user_id']; // Get logged-in user's ID
$today = date('Y-m-d'); // Get today's date

try {
    // Fetch the user's data and protein progress
    $stmt = $db->prepare("
        SELECT 
            u.full_name, u.phone, u.consumed_protein, bs.protein_goal 
        FROM users u
        LEFT JOIN body_stats bs ON u.user_id = bs.user_id
        WHERE u.user_id = :user_id AND u.phone IS NOT NULL
    ");
    $stmt->execute([':user_id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User data not found or phone number missing.");
    }

    $fullName = $user['full_name'];
    $phoneNumber = $user['phone'];
    $consumedProtein = $user['consumed_protein'];
    $proteinGoal = $user['protein_goal'];

    // Calculate the percentage of the protein goal achieved
    $proteinPercentage = ($consumedProtein / $proteinGoal) * 100;

    // Format phone number (ensure international format if not already)
    if (!preg_match('/^\+/', $phoneNumber)) {
        $phoneNumber = '+977' . preg_replace('/\D/', '', $phoneNumber); // Assuming Nepal (+977)
    }

    // Create a Twilio client
    $twilio = new Client($sid, $token);

    // Send a message when the user reaches 50% of their protein goal
    if ($proteinPercentage >= 50 && $proteinPercentage < 100) {
        $message = $twilio->messages->create(
            $phoneNumber,
            [
                'from' => $twilioPhoneNumber,
                'body' => "{$fullName}, your protein goal is half completed! Great job, keep going!",
            ]
        );
        echo "50% progress message sent to {$fullName} at {$phoneNumber}. SID: " . $message->sid . "\n";
    }

    // Send reminder every 2 hours if the goal is not yet completed
    if ($proteinPercentage < 100) {
        $lastReminderTime = $db->query("
            SELECT MAX(notification_sent_at) 
            FROM sms_notifications 
            WHERE user_id = {$userId} AND DATE(notification_sent_at) = '{$today}' 
              AND notification_type = 'protein_reminder'
        ")->fetchColumn();

        // Check if the last reminder was sent more than 2 hours ago
        if (!$lastReminderTime || (time() - strtotime($lastReminderTime)) > 7200) {
            $message = $twilio->messages->create(
                $phoneNumber,
                [
                    'from' => $twilioPhoneNumber,
                    'body' => "{$fullName}, don't forget to eat some protein! Keep it up!",
                ]
            );

            // Record the notification in the database
            $stmt = $db->prepare("
                INSERT INTO sms_notifications (user_id, notification_type, notification_sent_at) 
                VALUES (:user_id, :notification_type, NOW())
            ");
            $stmt->execute([
                ':user_id' => $userId,
                ':notification_type' => 'protein_reminder',
            ]);

            echo "Reminder message sent to {$fullName} at {$phoneNumber}. SID: " . $message->sid . "\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
