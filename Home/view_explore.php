
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
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800"><?php echo htmlspecialchars($institute['institute_name'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <img 
                    src="../uploads/<?php echo htmlspecialchars($institute['institute_image'], ENT_QUOTES, 'UTF-8'); ?>" 
                    alt="Institute Image" 
                    class="w-full h-80 object-cover rounded-lg shadow"
                >
            </div>
            <div>
                <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($institute['about'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p class="text-gray-500 mb-4"><strong>Location:</strong> <?php echo htmlspecialchars($institute['location'], ENT_QUOTES, 'UTF-8'); ?></p>
                <a 
                    href="<?php echo htmlspecialchars($institute['map_url'], ENT_QUOTES, 'UTF-8'); ?>" 
                    target="_blank" 
                    class="text-blue-600 underline"
                >
                    View on Map
                </a>
                <p class="text-gray-500 mt-4"><strong>Likes:</strong> <?php echo $institute['like_count']; ?></p>
                <button 
                    class="mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition duration-300"
                >
                    Like
                </button>
            </div>
        </div>
    </div>
</body>
</html>
