<?php
include_once '../config/db.php';
include_once '../includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $workout_name = $_POST['workout_name'];
    $description = $_POST['description'];
    $workout_type = $_POST['workout_type'];
    $reps = $_POST['reps'];
    $sets = $_POST['sets'];

    // Handle video upload (optional)
    $video_url = null;
    if (isset($_FILES['video']) && !empty($_FILES['video']['name'])) {
        $target_dir = "../uploads/videos/";
        $target_file = $target_dir . basename($_FILES["video"]["name"]);
        $uploadOk = 1;
        $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if video file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["video"]["size"] > 5000000) { // 5MB limit
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($videoFileType != "mp4" && $videoFileType != "mov" && $videoFileType != "avi" ) {
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            // Handle upload error
        } else {
            if (move_uploaded_file($_FILES["video"]["tmp_name"], $target_file)) {
                $video_url = "/uploads/videos/" . basename($_FILES["video"]["name"]); 
            } else {
                // Handle upload error
            }
        }
    }

    // Handle thumbnail upload (optional)
    $thumbnail_url = null;
    if (isset($_FILES['thumbnail']) && !empty($_FILES['thumbnail']['name'])) {
        $target_dir = "../uploads/thumbnails/";
        $target_file = $target_dir . basename($_FILES["thumbnail"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["thumbnail"]["size"] > 500000) { // 500KB limit
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            // Handle upload error
        } else {
            if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
                $thumbnail_url = "/uploads/thumbnails/" . basename($_FILES["thumbnail"]["name"]);

            } else {
                // Handle upload error
            }
            
        }
    }

    // Insert workout data into database
    try {
        $stmt = $db->prepare("INSERT INTO workout (workout_name, video_url, thumbnail_url, description, workout_type, reps, sets) 
                             VALUES (:workout_name, :video_url, :thumbnail_url, :description, :workout_type, :reps, :sets)");
        $stmt->bindParam(':workout_name', $workout_name);
        $stmt->bindParam(':video_url', $video_url);
        $stmt->bindParam(':thumbnail_url', $thumbnail_url);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':workout_type', $workout_type);
        $stmt->bindParam(':reps', $reps);
        $stmt->bindParam(':sets', $sets);
        $stmt->execute();

        // Redirect to success page
        header("Location: workout_success.php"); 
        exit;

    } catch(PDOException $e) {
        // Handle database error
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Workout</title>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-bold mb-6">Add Workout</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="workout_name" class="block text-gray-700 font-bold mb-2">Workout Name:</label>
                <input type="text" id="workout_name" name="workout_name" class="border border-gray-400 p-3 w-full rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">Description:</label>
                <textarea id="description" name="description" rows="4" class="border border-gray-400 p-3 w-full rounded-md" required></textarea>
            </div>
            <div class="mb-4">
                <label for="workout_type" class="block text-gray-700 font-bold mb-2">Workout Type:</label>
                <select id="workout_type" name="workout_type" class="border border-gray-400 p-3 w-full rounded-md">
                    <option value="strength">Strength</option>
                    <option value="cardio">Cardio</option>
                    <option value="yoga">Yoga</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="reps" class="block text-gray-700 font-bold mb-2">Reps:</label>
                <input type="number" id="reps" name="reps" class="border border-gray-400 p-3 w-full rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="sets" class="block text-gray-700 font-bold mb-2">Sets:</label>
                <input type="number" id="sets" name="sets" class="border border-gray-400 p-3 w-full rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="video" class="block text-gray-700 font-bold mb-2">Video:</label>
                <input type="file" id="video" name="video" accept="video/mp4,video/mov,video/avi" class="border border-gray-400 p-3 w-full rounded-md">
            </div>
            <div class="mb-4">
                <label for="thumbnail" class="block text-gray-700 font-bold mb-2">Thumbnail:</label>
                <input type="file" id="thumbnail" name="thumbnail" accept="image/jpeg,image/png,image/jpg" class="border border-gray-400 p-3 w-full rounded-md">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Workout</button>
        </form>
    </div>
</body>
</html>
