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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        .glassmorphism {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .profile-transition {
            transition: all 0.3s ease;
        }
        .profile-transition:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-purple-50 text-gray-800 min-h-screen">
    <?php include_once '../includes/sidebar.php'; ?>

    <!-- Top bar with 2FA Button -->
    <div class="flex justify-end items-center glassmorphism px-6 py-4 sticky top-0 z-10">
        <a href="../2fa.php" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-2.5 px-6 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5">
            <i class="fas fa-shield-alt mr-2"></i>Enable 2FA
        </a>
    </div>

    <div class="ml-64 p-8">
        <div class="max-w-5xl mx-auto">
            <div id="message" class="mb-4"></div>

            <!-- Profile Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Your Profile</h1>
                <p class="text-gray-600">Manage your personal information and fitness data</p>
            </div>

            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden profile-transition">
                <!-- Profile Image Section -->
                <div class="relative h-48 bg-gradient-to-r from-blue-400 to-purple-500">
                    <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                        <div class="relative group">
                            <?php if (!empty($user['profile_image'])): ?>
                                <img src="../uploads/<?php echo htmlspecialchars($user['profile_image']); ?>" 
                                     alt="Profile Picture" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                            <?php else: ?>
                                <img src="../images/default.jpg" 
                                     alt="Default Profile Picture" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                            <?php endif; ?>
                            <div class="absolute inset-0 rounded-full bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <form id="imageForm" enctype="multipart/form-data" class="flex flex-col items-center">
                                    <input type="file" name="profile_image" accept="image/*" class="hidden" id="profile_image">
                                    <label for="profile_image" class="text-white cursor-pointer">
                                        <i class="fas fa-camera text-2xl"></i>
                                    </label>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 pt-20">
                    <form id="profileForm" class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Personal Information Section -->
                            <div class="space-y-6">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-user-circle mr-2 text-blue-500"></i>
                                    Personal Information
                                </h2>
                                
                                <!-- Full Name -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" id="full_name" name="full_name" 
                                           value="<?php echo htmlspecialchars($user['full_name']); ?>" 
                                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                                </div>

                                <!-- Email -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" id="email" name="email" 
                                           value="<?php echo htmlspecialchars($user['email']); ?>" 
                                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                                </div>

                                <!-- Age -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Age</label>
                                    <input type="number" id="age" name="age" 
                                           value="<?php echo htmlspecialchars($user['age']); ?>" 
                                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                                </div>
                            </div>

                            <!-- Fitness Information Section -->
                            <div class="space-y-6">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-dumbbell mr-2 text-blue-500"></i>
                                    Fitness Information
                                </h2>

                                <!-- Weight & Height Group -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Weight (kg)</label>
                                        <input type="number" id="weight" name="weight" 
                                               value="<?php echo htmlspecialchars($user['weight']); ?>" 
                                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Height (cm)</label>
                                        <input type="number" id="height" name="height" 
                                               value="<?php echo htmlspecialchars($user['height']); ?>" 
                                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                                    </div>
                                </div>

                                <!-- Weekly Activities -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Activity Level</label>
                                    <select id="weekly_activities" name="weekly_activities" 
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                                        <option value="highly_active" <?php echo $user['weekly_activities'] === 'highly_active' ? 'selected' : ''; ?>>Highly Active</option>
                                        <option value="active" <?php echo $user['weekly_activities'] === 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="normal" <?php echo $user['weekly_activities'] === 'normal' ? 'selected' : ''; ?>>Normal</option>
                                    </select>
                                </div>

                                <!-- Read-only Information -->
                                <div class="grid grid-cols-1 gap-4 bg-gray-50 p-4 rounded-lg">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Gender</label>
                                        <input type="text" id="gender" name="gender" 
                                               value="<?php echo htmlspecialchars($user['gender']); ?>" 
                                               class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200" readonly>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Daily Protein Goal (g)</label>
                                        <input type="number" id="consumed_protein" name="consumed_protein" 
                                               value="<?php echo htmlspecialchars($user['consumed_protein']); ?>" 
                                               class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200" readonly>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Daily Water Goal (ml)</label>
                                        <input type="number" id="water_goal" name="water_goal" 
                                               value="<?php echo htmlspecialchars($user['water_goal']); ?>" 
                                               class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Update Button -->
                        <div class="flex justify-end pt-6">
                            <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-save mr-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Handle profile image upload with preview
            $('#profile_image').on('change', function() {
                if (this.files && this.files[0]) {
                    let formData = new FormData($('#imageForm')[0]);
                    
                    $.ajax({
                        url: '../controller/update_profile_image.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('#message').html(`
                                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md mb-4 fade-in" role="alert">
                                    <p class="font-bold">Success!</p>
                                    <p>${response.message}</p>
                                </div>
                            `);
                            setTimeout(() => location.reload(), 2000);
                        },
                        error: function(error) {
                            $('#message').html(`
                                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md mb-4 fade-in" role="alert">
                                    <p class="font-bold">Error!</p>
                                    <p>${error.responseJSON.message}</p>
                                </div>
                            `);
                        }
                    });
                }
            });

            // Handle profile update with enhanced feedback
            $('#profileForm').on('submit', function(e) {
                e.preventDefault();
                const submitButton = $(this).find('button[type="submit"]');
                submitButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...');

                $.ajax({
                    url: 'update_profile.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#message').html(`
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md mb-4 fade-in" role="alert">
                                <p class="font-bold">Success!</p>
                                <p>Profile updated successfully!</p>
                            </div>
                        `);
                        submitButton.prop('disabled', false).html('<i class="fas fa-save mr-2"></i>Save Changes');
                    },
                    error: function() {
                        $('#message').html(`
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md mb-4 fade-in" role="alert">
                                <p class="font-bold">Error!</p>
                                <p>Failed to update profile. Please try again.</p>
                            </div>
                        `);
                        submitButton.prop('disabled', false).html('<i class="fas fa-save mr-2"></i>Save Changes');
                    }
                });
            });
        });
    </script>
</body>
</html>