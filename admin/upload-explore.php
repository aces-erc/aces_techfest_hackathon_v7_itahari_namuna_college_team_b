<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../config/db.php';
include_once '../includes/session.php'; // Include session for admin access

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form inputs
    $instituteName = trim($_POST['institute_name']);
    $about = trim($_POST['about']);
    $location = trim($_POST['location']);
    $mapUrl = trim($_POST['map_url']);
    $likeCount = 0; // Default like count

    // Validate inputs
    $errors = [];
    if (empty($instituteName)) $errors[] = "Institute name is required.";
    if (empty($about)) $errors[] = "About field is required.";
    if (empty($location)) $errors[] = "Location is required.";
    if (empty($mapUrl) || !filter_var($mapUrl, FILTER_VALIDATE_URL)) {
        $errors[] = "A valid map URL is required.";
    }

    // Handle file upload
    $targetDir = "../uploads/";
    $fileName = basename($_FILES["institute_image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    if (empty($fileName)) {
        $errors[] = "Institute image is required.";
    } elseif (!in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        $errors[] = "Only JPG, JPEG, PNG, and GIF files are allowed.";
    }

    // If there are errors, redirect back with error messages
    if (!empty($errors)) {
        $error_message = implode(", ", $errors);
        header("Location: upload-explore.php?error=" . urlencode($error_message));
        exit();
    }

    // Move uploaded file
    if (!move_uploaded_file($_FILES["institute_image"]["tmp_name"], $targetFilePath)) {
        header("Location: upload-explore.php?error=" . urlencode("Failed to upload the image."));
        exit();
    }

    // Insert into database
    try {
        $stmt = $db->prepare("
            INSERT INTO explore (institute_image, institute_name, map_url, about, location, like_count) 
            VALUES (:institute_image, :institute_name, :map_url, :about, :location, :like_count)
        ");
        $stmt->execute([
            ':institute_image' => $fileName,
            ':institute_name' => $instituteName,
            ':map_url' => $mapUrl,
            ':about' => $about,
            ':location' => $location,
            ':like_count' => $likeCount,
        ]);

        // Redirect with success message
        header("Location: view_explore.php?success=1");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Explore</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-gray-700">Add Fitness Institute</h1>
        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <?= htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="institute_name" class="block text-gray-600 font-medium">Institute Name</label>
                <input type="text" name="institute_name" id="institute_name" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div class="mb-4">
                <label for="about" class="block text-gray-600 font-medium">About</label>
                <textarea name="about" id="about" rows="3" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required></textarea>
            </div>
            <div class="mb-4">
                <label for="location" class="block text-gray-600 font-medium">Location</label>
                <input type="text" name="location" id="location" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div class="mb-4">
                <label for="map_url" class="block text-gray-600 font-medium">Map URL</label>
                <input type="url" name="map_url" id="map_url" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div class="mb-4">
                <label for="institute_image" class="block text-gray-600 font-medium">Institute Image</label>
                <input type="file" name="institute_image" id="institute_image" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded shadow hover:bg-indigo-700 transition-all">Submit</button>
        </form>
    </div>
</body>
</html>
