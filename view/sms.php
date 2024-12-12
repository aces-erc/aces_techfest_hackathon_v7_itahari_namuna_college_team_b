<?php
// Include your database and session
include_once '../config/db.php';
include_once '../includes/session.php';

// Autoload the Twilio PHP SDK
require_once '../vendor/autoload.php';

use Twilio\Rest\Client;

// Twilio credentials
$sid = "ACba494322e03e6d0db251c7ec1a1b09d1"; // Replace with your SID
$token = "a05160deb493d06c62e87d1f9d217be4"; // Replace with your Auth Token
$twilioPhoneNumber = "+13203356186"; // Replace with your Twilio number

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the user is logged in
    if (!isset($_SESSION['user_id'])) {
        die(json_encode(['status' => 'error', 'message' => 'User not logged in.']));
    }

    $userId = $_SESSION['user_id']; // Get logged-in user's ID

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
            die(json_encode(['status' => 'error', 'message' => 'User data not found or phone number missing.']));
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

        // Send SMS when protein percentage crosses 50%
        if ($proteinPercentage >= 50) {
            // Create a Twilio client
            $twilio = new Client($sid, $token);

            $message = $twilio->messages->create(
                $phoneNumber,
                [
                    'from' => $twilioPhoneNumber,
                    'body' => "Congratulations! {$fullName}, you have consumed 50% of your protein goal. Keep it up!",
                ]
            );

            echo json_encode(['status' => 'success', 'message' => 'SMS sent successfully.', 'sid' => $message->sid]);
            exit;
        }

        echo json_encode(['status' => 'info', 'message' => 'Protein goal not yet reached.']);
        exit;
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit;
    }
}
?>
<script>
    function checkProteinProgress() {
        fetch('../controller/sms.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log(data.message); // Log success message
                } else if (data.status === 'info') {
                    console.log(data.message); // Log info message
                } else {
                    console.error(data.message); // Log error
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Check protein progress every 5 minutes
    setInterval(checkProteinProgress, 300000); // 300000 ms = 5 minutes
</script>
