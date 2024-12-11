<?php
include_once '../config/db.php';
include_once '../includes/session.php';

$userId = $_SESSION['user_id'];
$request = json_decode(file_get_contents('php://input'), true);

$day = $request['day']; // Example: "2024-12-10"
$status = $request['status']; // "workout" or "notworkout"

try {
    $stmt = $db->prepare("
        INSERT INTO user_workout_calendar (user_id, day, status)
        VALUES (:user_id, :day, :status)
        ON DUPLICATE KEY UPDATE status = :status
    ");
    $stmt->execute([
        ':user_id' => $userId,
        ':day' => $day,
        ':status' => $status
    ]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
