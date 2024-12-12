<?php
include_once '../config/db.php';
include_once '../includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $user_id = $_SESSION['user_id'];

    // Optional additional fields
    $age = isset($_POST['age']) ? (int)$_POST['age'] : null;
    $weight = isset($_POST['weight']) ? (float)$_POST['weight'] : null;
    $height = isset($_POST['height']) ? (float)$_POST['height'] : null;
    $weekly_activities = isset($_POST['weekly_activities']) ? trim($_POST['weekly_activities']) : null;

    if (empty($full_name) || empty($email)) {
        http_response_code(400);
        echo json_encode(['message' => 'Full name and email are required.']);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid email format.']);
        exit();
    }

    // Handle profile image upload if provided
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/';
        $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $file_name = 'user_' . $user_id . '_' . time() . '.' . $file_extension;
        $target_file = $upload_dir . $file_name;

        if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to upload profile image.']);
            exit();
        }

        // Save the new profile image in the database
        $profile_image_stmt = $db->prepare("UPDATE users SET profile_image = :profile_image WHERE user_id = :user_id");
        $profile_image_stmt->execute([
            ':profile_image' => $file_name,
            ':user_id' => $user_id,
        ]);
    }

    try {
        // Update user data in the database
        $stmt = $db->prepare("
            UPDATE users 
            SET 
                full_name = :full_name, 
                email = :email,
                age = :age,
                weight = :weight,
                height = :height,
                weekly_activities = :weekly_activities
            WHERE user_id = :user_id
        ");
        $stmt->execute([
            ':full_name' => $full_name,
            ':email' => $email,
            ':age' => $age,
            ':weight' => $weight,
            ':height' => $height,
            ':weekly_activities' => $weekly_activities,
            ':user_id' => $user_id,
        ]);

        echo json_encode(['message' => 'Profile updated successfully.']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Failed to update profile.']);
    }
}
