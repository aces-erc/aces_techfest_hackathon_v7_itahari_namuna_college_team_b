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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile - FitNepal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen">
    <?php include_once '../includes/sidebar.php'; ?>

    <div class="ml-64 p-8">
        <div class="max-w-4xl mx-auto">
            <div id="message" class="mb-4"></div>

            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col items-center mb-6">
                        <?php if (!empty($user['profile_image'])): ?>
                            <img src="../uploads/<?php echo htmlspecialchars($user['profile_image']); ?>" 
                                 alt="Profile Picture" 
                                 class="w-32 h-32 rounded-full object-cover mb-4 border-4 border-blue-500">
                        <?php else: ?>
                            <img src="../images/default.jpg" 
                                 alt="Default Profile Picture" 
                                 class="w-32 h-32 rounded-full object-cover mb-4 border-4 border-blue-500">
                        <?php endif; ?>

                        <form id="imageForm" enctype="multipart/form-data">
                            <input type="file" name="profile_image" accept="image/*" class="hidden" id="profile_image">
                            <label for="profile_image" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded cursor-pointer">
                                Choose Image
                            </label>
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded mt-2">
                                Upload
                            </button>
                        </form>
                    </div>

                    <form id="profileForm" class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Full Name -->
        <div class="space-y-2">
            <label for="full_name" class="block text-sm font-medium text-gray-700">
                <i class="fas fa-user mr-2 text-blue-500"></i>Full Name
            </label>
            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <!-- Email -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-medium text-gray-700">
                <i class="fas fa-envelope mr-2 text-blue-500"></i>Email
            </label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <!-- Age -->
        <div class="space-y-2">
            <label for="age" class="block text-sm font-medium text-gray-700">
                <i class="fas fa-birthday-cake mr-2 text-blue-500"></i>Age
            </label>
            <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($user['age']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <!-- Weight -->
        <div class="space-y-2">
            <label for="weight" class="block text-sm font-medium text-gray-700">
                <i class="fas fa-weight mr-2 text-blue-500"></i>Weight (kg)
            </label>
            <input type="number" id="weight" name="weight" value="<?php echo htmlspecialchars($user['weight']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <!-- Height -->
        <div class="space-y-2">
            <label for="height" class="block text-sm font-medium text-gray-700">
                <i class="fas fa-ruler-vertical mr-2 text-blue-500"></i>Height (cm)
            </label>
            <input type="number" id="height" name="height" value="<?php echo htmlspecialchars($user['height']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <!-- Weekly Activities -->
        <div class="space-y-2">
            <label for="weekly_activities" class="block text-sm font-medium text-gray-700">
                <i class="fas fa-running mr-2 text-blue-500"></i>Weekly Activities
            </label>
            <select id="weekly_activities" name="weekly_activities" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="highly_active" <?php echo $user['weekly_activities'] === 'highly_active' ? 'selected' : ''; ?>>Highly Active</option>
                <option value="active" <?php echo $user['weekly_activities'] === 'active' ? 'selected' : ''; ?>>Active</option>
                <option value="normal" <?php echo $user['weekly_activities'] === 'normal' ? 'selected' : ''; ?>>Normal</option>
            </select>
        </div>
        <!-- Gender -->
        <div class="space-y-2">
            <label for="gender" class="block text-sm font-medium text-gray-700">
                <i class="fas fa-venus-mars mr-2 text-blue-500"></i>Gender
            </label>
            <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($user['gender']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
        </div>
        <!-- Consumed Protein -->
        <div class="space-y-2">
            <label for="consumed_protein" class="block text-sm font-medium text-gray-700">
                <i class="fas fa-drumstick-bite mr-2 text-blue-500"></i>Consumed Protein (g)
            </label>
            <input type="number" id="consumed_protein" name="consumed_protein" value="<?php echo htmlspecialchars($user['consumed_protein']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
        </div>
        <!-- Water Goal -->
        <div class="space-y-2">
            <label for="water_goal" class="block text-sm font-medium text-gray-700">
                <i class="fas fa-tint mr-2 text-blue-500"></i>Water Goal (ml)
            </label>
            <input type="number" id="water_goal" name="water_goal" value="<?php echo htmlspecialchars($user['water_goal']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110">
            <i class="fas fa-save mr-2"></i>Update Profile
        </button>
    </div>
</form>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Handle profile image upload
            $('#imageForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: '../controller/update_profile_image.php',
                    type: 'POST',
                    data: formData,
                    processData: false,

                    contentType: false,
                    success: function(response) {
                        $('#message').html('<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert"><p class="font-bold">Success!</p><p>' + response.message + '</p></div>');
                        setTimeout(() => location.reload(), 2000);
                    },
                    error: function(error) {
                        $('#message').html('<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert"><p class="font-bold">Error!</p><p>' + error.responseJSON.message + '</p></div>');
                    }
                });
            });

            // Handle profile update
            $('#profileForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'update_profile.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#message').html('<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert"><p class="font-bold">Success!</p><p>Profile updated successfully!</p></div>');
                    },
                    error: function() {
                        $('#message').html('<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert"><p class="font-bold">Error!</p><p>Failed to update profile. Please try again.</p></div>');
                    }
                });
            });
        });
    </script>
</body>
</html>
