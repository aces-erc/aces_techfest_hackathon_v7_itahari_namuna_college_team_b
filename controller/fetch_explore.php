<?php
include_once '../config/db.php';

// Fetch the selected location from the GET request
$location = $_GET['location'] ?? 'all';

try {
    if ($location === 'all') {
        // Only fetch institutes if there are any available
        $stmt = $db->prepare("SELECT * FROM explore WHERE location IS NOT NULL AND location != ''");
    } else {
        // Fetch institutes matching the selected location
        $stmt = $db->prepare("SELECT * FROM explore WHERE location = :location");
        $stmt->bindParam(':location', $location, PDO::PARAM_STR);
    }
    $stmt->execute();
    $institutes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display results if institutes are found
    if (!empty($institutes)) {
        foreach ($institutes as $institute) {
            echo '
                <a href="view_explore.php?id=' . htmlspecialchars($institute['id'], ENT_QUOTES, 'UTF-8') . '" 
                   class="block bg-white p-4 rounded-lg shadow hover:shadow-lg">
                    <img src="../uploads/' . htmlspecialchars($institute['institute_image'], ENT_QUOTES, 'UTF-8') . '" 
                         alt="Institute Image" class="w-full h-48 object-cover rounded-t-lg">
                    <div class="p-4">
                        <h2 class="text-xl font-bold text-gray-800">' . htmlspecialchars($institute['institute_name'], ENT_QUOTES, 'UTF-8') . '</h2>
                        <p class="text-gray-600 mt-2">' . htmlspecialchars(mb_strimwidth($institute['about'], 0, 100, '...'), ENT_QUOTES, 'UTF-8') . '</p>
                        <p class="text-gray-500 mt-2"><strong>Location:</strong> ' . htmlspecialchars($institute['location'], ENT_QUOTES, 'UTF-8') . '</p>
                    </div>
                </a>';
        }
    } else {
        // Show a message if no results are found
        echo '<p class="col-span-3 text-center text-gray-500">No institutes found for the selected location.</p>';
    }
} catch (PDOException $e) {
    echo '<p class="col-span-3 text-center text-red-500">Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>';
}
?>

