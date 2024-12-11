<?php
include_once '../config/db.php';

// Fetch institutes filtered by location (default: all)
$location = $_GET['location'] ?? 'all';
try {
    if ($location === 'all') {
        $stmt = $db->prepare("SELECT * FROM explore");
    } else {
        $stmt = $db->prepare("SELECT * FROM explore WHERE location = :location");
        $stmt->bindParam(':location', $location, PDO::PARAM_STR);
    }
    $stmt->execute();
    $institutes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Fitness Institutes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Explore Fitness Institutes</h1>
        <div class="mb-6">
            <form method="get" class="flex space-x-4">
                <select name="location" class="p-2 border rounded">
                    <option value="all">All Locations</option>
                    <option value="Itahari" <?= $location === 'Itahari' ? 'selected' : '' ?>>Itahari</option>
                    <option value="Morang" <?= $location === 'Morang' ? 'selected' : '' ?>>Morang</option>
                    <option value="Biratnagar" <?= $location === 'Biratnagar' ? 'selected' : '' ?>>Biratnagar</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Filter</button>
            </form>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php foreach ($institutes as $institute): ?>
                <div 
                    onclick="location.href='view_explore.php?id=<?php echo $institute['institute_id']; ?>'" 
                    class="bg-white rounded-lg shadow hover:shadow-lg cursor-pointer overflow-hidden transform transition duration-300 hover:scale-105"
                >
                    <img 
                        src="../uploads/<?php echo $institute['institute_image']; ?>" 
                        alt="Institute Image" 
                        class="w-full h-48 object-cover"
                    >
                    <div class="p-4">
                        <h2 class="text-xl font-bold text-gray-800"><?php echo $institute['institute_name']; ?></h2>
                        <p class="text-gray-600 mt-2"><?php echo substr($institute['about'], 0, 60); ?>...</p>
                        <p class="text-gray-500 mt-2"><strong>Location:</strong> <?php echo $institute['location']; ?></p>
                        <p class="text-gray-500 mt-2"><strong>Likes:</strong> <?php echo $institute['like_count']; ?></p>
                        <div class="mt-4 flex justify-between items-center">
                            <a 
                                href="<?php echo $institute['map_url']; ?>" 
                                target="_blank" 
                                class="text-blue-500 inline-block"
                            >
                                View on Map
                            </a>
                            <button 
                                class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition duration-300"
                            >
                                Like
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
