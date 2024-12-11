<?php
include_once '../config/db.php';
include_once '../includes/session.php';

$userId = $_SESSION['user_id'];

try {
    $stmt = $db->prepare("SELECT day, status FROM user_workout_calendar WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $userId]);
    $calendar = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($calendar);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>


