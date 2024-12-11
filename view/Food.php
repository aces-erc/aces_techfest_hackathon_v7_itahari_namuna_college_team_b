<?php
include_once '../config/db.php';
include_once '../includes/session.php'; // Ensure session is included to get user ID

$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

// Handle AJAX request for adding food
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $food_name = trim($_POST['food_name']);
    $protein = floatval($_POST['protein']);
    $calorie = floatval($_POST['calorie']);
    $carbs = floatval($_POST['carbs']);

    // Insert into the `user_food` table
    try {
        $stmt = $db->prepare("INSERT INTO user_food (user_id, food_name, protein, calorie, carbs) VALUES (:user_id, :food_name, :protein, :calorie, :carbs)");
        $stmt->execute([
            ':user_id' => $user_id,
            ':food_name' => $food_name,
            ':protein' => $protein,
            ':calorie' => $calorie,
            ':carbs' => $carbs,
        ]);
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit();
}

// Fetch all added foods for the user
try {
    $stmt = $db->prepare("SELECT * FROM user_food WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    $userFoods = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate totals
    $totalProtein = array_sum(array_column($userFoods, 'protein'));
    $totalCalories = array_sum(array_column($userFoods, 'calorie'));
    $totalCarbs = array_sum(array_column($userFoods, 'carbs'));
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <?php include_once '../includes/sidebar.php'; ?>

    <div class="ml-64 p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Add Food</h1>

<?php include '../components/total_data.php'; ?>

        <!-- Add Food Form -->
        <div class="bg-white p-6 rounded-lg shadow mb-6 max-w-4xl">
            <h2 class="text-xl font-bold mb-4">Quick Add Food</h2>
            <form id="addFoodForm" class="flex flex-col space-y-4">
                <div>
                    <label for="food_name" class="block text-sm font-medium text-gray-700">Food Name</label>
                    <input type="text" id="food_name" name="food_name" class="p-2 border rounded w-full" required>
                </div>
                <div>
                    <label for="protein" class="block text-sm font-medium text-gray-700">Protein (grams)</label>
                    <input type="number" id="protein" name="protein" step="0.1" class="p-2 border rounded w-full" required>
                </div>
                <div>
                    <label for="calorie" class="block text-sm font-medium text-gray-700">Calories</label>
                    <input type="number" id="calorie" name="calorie" step="0.1" class="p-2 border rounded w-full" required>
                </div>
                <div>
                    <label for="carbs" class="block text-sm font-medium text-gray-700">Carbs (grams)</label>
                    <input type="number" id="carbs" name="carbs" step="0.1" class="p-2 border rounded w-full" required>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add Food</button>
            </form>
        </div>

        <!-- Search Nutrition -->
        <div class="bg-white p-6 rounded-lg shadow mb-6 max-w-4xl">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Search Nutrition Database</h2>
            <input type="text" id="searchFood" class="p-2 border rounded w-full mb-4" placeholder="Search food...">
            <div id="nutritionResults" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
        </div>

        <!-- Added Foods -->
        <div class="bg-white p-6 rounded-lg shadow max-w-4xl">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Your Added Foods</h2>
            <ul id="userFoodsList" class="list-disc pl-6">
                <?php if (!empty($userFoods)): ?>
                    <?php foreach ($userFoods as $food): ?>
                        <li class="text-gray-700">
                            <?php echo htmlspecialchars($food['food_name'], ENT_QUOTES, 'UTF-8'); ?> 
                            (Protein: <?php echo htmlspecialchars($food['protein'], ENT_QUOTES, 'UTF-8'); ?>g, 
                            Calories: <?php echo htmlspecialchars($food['calorie'], ENT_QUOTES, 'UTF-8'); ?> kcal, 
                            Carbs: <?php echo htmlspecialchars($food['carbs'], ENT_QUOTES, 'UTF-8'); ?>g)
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500">No foods added yet.</p>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Add food via AJAX
            $('#addFoodForm').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                $.ajax({
                    url: 'food.php',
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        const data = JSON.parse(response);
                        if (data.status === 'success') {
                            alert('Food added successfully!');
                            location.reload(); // Refresh to show the updated food list and totals
                        } else {
                            alert('Error adding food: ' + data.message);
                        }
                    },
                    error: function () {
                        alert('Failed to add food.');
                    }
                });
            });

            // Search nutrition database
            $('#searchFood').on('input', function () {
                const query = $(this).val();
                if (query.length > 1) {
                    $.ajax({
                        url: '../controller/search_nutrition.php', // Endpoint to search `nutrition` table
                        method: 'GET',
                        data: { query },
                        success: function (response) {
                            const foods = JSON.parse(response);
                            let html = '';
                            foods.forEach(food => {
                                html += `
                                    <div class="flex items-center justify-between p-4 bg-gray-50 border rounded">
                                        <div>
                                            <p class="font-bold text-gray-700">${food.food_name}</p>
                                            <p class="text-sm text-gray-500">
                                                Protein: ${food.protein}g, Calories: ${food.calorie} kcal, Carbs: ${food.carbs}g
                                            </p>
                                        </div>
                                        <button 
                                            class="px-3 py-1 bg-green-500 text-white rounded addFoodButton" 
                                            data-name="${food.food_name}" 
                                            data-protein="${food.protein}" 
                                            data-calorie="${food.calorie}" 
                                            data-carbs="${food.carbs}"
                                        >
                                            +
                                        </button>
                                    </div>
                                `;
                            });
                            $('#nutritionResults').html(html);
                        },
                        error: function () {
                            alert('Failed to search nutrition database.');
                        }
                    });
                } else {
                    $('#nutritionResults').html('');
                }
            });

            // Add food from nutrition database
            $(document).on('click', '.addFoodButton', function () {
                const food_name = $(this).data('name');
                const protein = $(this).data('protein');
                const calorie = $(this).data('calorie');
                const carbs = $(this).data('carbs');
                $.ajax({
                    url: 'food.php',
                    method: 'POST',
                    data: { food_name, protein, calorie, carbs },
                    success: function (response) {
                        const data = JSON.parse(response);
                        if (data.status === 'success') {
                            alert('Food added successfully!');
                            location.reload(); // Refresh to show the updated food list and totals
                        } else {
                            alert('Error adding food: ' + data.message);
                        }
                    },
                    error: function () {
                        alert('Failed to add food.');
                    }
                });
            });
        });
    </script>
</body>
</html>
