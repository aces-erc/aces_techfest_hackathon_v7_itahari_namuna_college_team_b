<?php
include_once '../config/db.php';
include_once '../includes/session.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Check if the user has a record in `prompt_usage`
    $stmt = $db->prepare("SELECT * FROM prompt_usage WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    $usage = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usage) {
        // Create a record if not exists
        $paymentStmt = $db->prepare("SELECT status FROM manual_pay WHERE user_id = :user_id");
        $paymentStmt->execute([':user_id' => $user_id]);
        $paymentStatus = $paymentStmt->fetch(PDO::FETCH_ASSOC);

        $max_prompts = ($paymentStatus && $paymentStatus['status'] === 'paid') ? 1000 : 5;
        $status = ($paymentStatus && $paymentStatus['status'] === 'paid') ? 'paid' : 'free';

        $insertStmt = $db->prepare("
            INSERT INTO prompt_usage (user_id, max_prompts, current_prompts, status)
            VALUES (:user_id, :max_prompts, 0, :status)
        ");
        $insertStmt->execute([':user_id' => $user_id, ':max_prompts' => $max_prompts, ':status' => $status]);

        $usage = [
            'user_id' => $user_id,
            'max_prompts' => $max_prompts,
            'current_prompts' => 0,
            'status' => $status
        ];
    }

    // If a POST request, increment prompt usage
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($usage['current_prompts'] < $usage['max_prompts']) {
            $incrementStmt = $db->prepare("
                UPDATE prompt_usage 
                SET current_prompts = current_prompts + 1 
                WHERE user_id = :user_id
            ");
            $incrementStmt->execute([':user_id' => $user_id]);

            $usage['current_prompts']++;
        } else {
            echo json_encode(['error' => 'Prompt limit reached']);
            exit();
        }
    }

    echo json_encode($usage);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
