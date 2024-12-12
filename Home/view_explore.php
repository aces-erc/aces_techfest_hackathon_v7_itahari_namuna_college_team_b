
<?php
include_once '../config/db.php';

// Check and sanitize the institute ID from the query parameter
$institute_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;

if (!$institute_id) {
    echo "<h1 class='text-center text-red-500 mt-10'>Invalid Institute ID</h1>";
    exit();
}

try {
    $stmt = $db->prepare("SELECT * FROM explore WHERE id = :id");
    $stmt->bindParam(':id', $institute_id, PDO::PARAM_INT);
    $stmt->execute();
    $institute = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$institute) {
        echo "<h1 class='text-center text-red-500 mt-10'>Institute not found!</h1>";
        exit();
    }
} catch (PDOException $e) {
    echo "<h1 class='text-center text-red-500 mt-10'>Error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</h1>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($institute['institute_name'], ENT_QUOTES, 'UTF-8'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<?php include 'navbar.php'; ?>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="container mx-auto p-4 md:p-8 max-w-7xl">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                <?php echo htmlspecialchars($institute['institute_name'], ENT_QUOTES, 'UTF-8'); ?>
            </h1>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6">
                <!-- Image Section -->
                <div class="space-y-6">
                    <div class="relative group">
                        <img 
                            src="../uploads/<?php echo htmlspecialchars($institute['institute_image'], ENT_QUOTES, 'UTF-8'); ?>" 
                            alt="Institute Image" 
                            class="w-full h-96 object-cover rounded-lg shadow-md transform transition duration-300 group-hover:scale-[1.02]"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg"></div>
                    </div>
                    
                    <!-- Like Section -->
                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-heart text-red-500"></i>
                            <span class="text-gray-700 font-medium"><?php echo $institute['like_count']; ?> Likes</span>
                        </div>
                        <button 
                            class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition duration-300 flex items-center space-x-2 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
                        >
                            <i class="fas fa-thumbs-up"></i>
                            <span>Like</span>
                        </button>
                    </div>
                </div>

                <!-- Information Section -->
                <div class="space-y-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">About Us</h2>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo htmlspecialchars($institute['about'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Location</h2>
                        <div class="space-y-4">
                            <p class="text-gray-600 flex items-center space-x-2">
                                <i class="fas fa-map-marker-alt text-blue-500"></i>
                                <span><?php echo htmlspecialchars($institute['location'], ENT_QUOTES, 'UTF-8'); ?></span>
                            </p>
                            <a 
                                href="<?php echo htmlspecialchars($institute['map_url'], ENT_QUOTES, 'UTF-8'); ?>" 
                                target="_blank" 
                                class="inline-flex items-center space-x-2 text-blue-600 hover:text-blue-700 transition duration-300"
                            >
                                <i class="fas fa-external-link-alt"></i>
                                <span>View on Map</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>