<?php
include_once '../config/db.php';

// Get current date
$currentDate = date('Y-m-d');

// Fetch all active users and their daily goals
try {
    $stmt = $db->prepare("
        SELECT user_id, protein_goal, consumed_protein 
        FROM users 
        WHERE status = 'active'
    ");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        $user_id = $user['user_id'];
        $proteinGoal = $user['protein_goal'];
        $consumedProtein = $user['consumed_protein'];

        // Determine if the goal was completed
        $status = ($consumedProtein >= $proteinGoal) ? 'completed' : 'incompleted';
        $completedPercentage = min(100, round(($consumedProtein / $proteinGoal) * 100));

        // Insert the daily record into `protein_progress` table
        $progressStmt = $db->prepare("
            INSERT INTO protein_progress (user_id, date, status, completed_percentage) 
            VALUES (:user_id, :date, :status, :completed_percentage)
        ");
        $progressStmt->execute([
            ':user_id' => $user_id,
            ':date' => $currentDate,
            ':status' => $status,
            ':completed_percentage' => $completedPercentage
        ]);

        // Reset consumed protein for the next day
        $resetStmt = $db->prepare("
            UPDATE users 
            SET consumed_protein = 0 
            WHERE user_id = :user_id
        ");
        $resetStmt->execute([':user_id' => $user_id]);
    }

    echo "Daily protein progress recorded and reset successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
