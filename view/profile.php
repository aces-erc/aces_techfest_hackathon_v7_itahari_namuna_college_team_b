<?php
include_once '../config/db.php';
include_once '../includes/session.php';

// Fetch user data from the database
try {
    $stmt = $db->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("User not found.");
    }
} catch (Exception $e) {
    die("Error fetching user data: " . $e->getMessage());
}

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $user_id = $_SESSION['user_id']; 
    $target_dir = "../uploads/";
    $file_extension = pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION);
    $file_name = "user_" . $user_id . "_" . time() . "." . $file_extension;
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
        // Update user's profile image in the database
        $stmt = $db->prepare("UPDATE users SET profile_image = :profile_image WHERE user_id = :user_id");
        $stmt->execute([':profile_image' => $file_name, ':user_id' => $user_id]);
        $success_message = "Profile image updated successfully.";
    } else {
        $error_message = "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile - FitNepal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#1E40AF] text-white min-h-screen">
    <?php include_once '../includes/sidebar.php'; ?>

    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-8">Your Profile</h1>

        <?php if (isset($success_message)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $success_message; ?></span>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $error_message; ?></span>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <?php if (isset($user['profile_image']) && !empty($user['profile_image'])): ?>
                        <img src="../uploads/<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Picture" class="w-24 h-24 rounded-full object-cover mr-4">
                    <?php else: ?>
                        <img src="../images/default_profile.png" alt="Default Profile Picture" class="w-24 h-24 rounded-full object-cover mr-4">
                    <?php endif; ?>

                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="file" name="profile_image" accept="image/*" class="hidden" id="profile_image">
                        <label for="profile_image" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded cursor-pointer">
                            Choose File
                        </label>
                    </form>
                </div>

                <table class="w-full text-left">
                    <tbody>
                        <tr>
                            <th class="p-3 text-gray-800">Name:</th>
                            <td class="p-3 text-gray-800"><?php echo htmlspecialchars($user['full_name']); ?></td>
                        </tr>
                        <tr>
                            <th class="p-3 text-gray-800">Email:</th>
                            <td class="p-3 text-gray-800"><?php echo htmlspecialchars($user['email']); ?></td>
                        </tr>
                        <tr>
                            <th class="p-3 text-gray-800">Phone:</th>
                            <td class="p-3 text-gray-800"><?php echo htmlspecialchars($user['phone']); ?></td>
                        </tr>
                        </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Add any JavaScript for interactivity here
    </script>
</body>
</html>