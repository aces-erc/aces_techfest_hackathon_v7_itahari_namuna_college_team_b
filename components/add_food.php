<?php
include_once '../config/db.php';
include_once '../includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $action = $data['action'] ?? '';

    if ($action === 'add_food') {
        $user_id = $_SESSION['user_id'];
        $food_name = $data['food_name'] ?? '';
        $protein = $data['protein'] ?? 0;
        $calorie = $data['calorie'] ?? 0;

        if (empty($food_name)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid food name']);
            exit();
        }

        try {
            // Updated SQL query to exclude the 'carbs' field
            $stmt = $db->prepare("INSERT INTO user_food (user_id, food_name, protein, calorie) VALUES (:user_id, :food_name, :protein, :calorie)");
            $stmt->execute([
                ':user_id' => $user_id,
                ':food_name' => $food_name,
                ':protein' => $protein,
                ':calorie' => $calorie,
            ]);
            echo json_encode(['status' => 'success']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    }
}
?>
