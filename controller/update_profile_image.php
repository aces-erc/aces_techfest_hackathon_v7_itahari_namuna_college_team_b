<?php
include_once '../config/db.php';
include_once '../includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $user_id = $_SESSION['user_id'];
    $target_dir = "../uploads/";
    $file_extension = pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION);
    $file_name = "user_" . $user_id . "_" . time() . "." . $file_extension;
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
        try {
            $stmt = $db->prepare("UPDATE users SET profile_image = :profile_image WHERE user_id = :user_id");
            $stmt->execute([
                ':profile_image' => $file_name,
                ':user_id' => $user_id,
            ]);

            echo json_encode(['message' => 'Profile image updated successfully.']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to update profile image.']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Failed to upload image.']);
    }
}
