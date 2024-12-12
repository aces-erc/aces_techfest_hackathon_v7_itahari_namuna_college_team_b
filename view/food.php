<?php
include_once '../config/db.php';
include_once '../includes/session.php'; // Ensure session is included to get user ID

$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

// Handle AJAX request for adding food
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $food_name = trim($_POST['food_name']);
    $protein = floatval($_POST['protein']);
    $calorie = floatval($_POST['calorie']);

    try {
        // Insert into the `user_food` table
        $stmt = $db->prepare("INSERT INTO user_food (user_id, food_name, protein, calorie) VALUES (:user_id, :food_name, :protein, :calorie)");
        $stmt->execute([
            ':user_id' => $user_id,
            ':food_name' => $food_name,
            ':protein' => $protein,
            ':calorie' => $calorie,
        ]);

        // Calculate the new total protein consumed by the user
        $stmt = $db->prepare("SELECT SUM(protein) AS total_protein FROM user_food WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        $totalProtein = $stmt->fetch(PDO::FETCH_ASSOC)['total_protein'];

        // Update the `consumed_protein` column in the `users` table
        $updateStmt = $db->prepare("UPDATE users SET consumed_protein = :consumed_protein WHERE user_id = :user_id");
        $updateStmt->execute([
            ':consumed_protein' => $totalProtein,
            ':user_id' => $user_id,
        ]);

        echo json_encode(['status' => 'success', 'totalProtein' => $totalProtein]);
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php include_once '../includes/sidebar.php'; ?>

    <div class="ml-64 p-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-8 fade-in">
                <h1 class="text-4xl font-bold text-gray-800">Add Food 🍽️</h1>
                <div class="bg-blue-50 rounded-full px-6 py-2">
                    <span class="text-blue-600 font-semibold">Track your nutrition journey</span>
                </div>
            </div>

            <?php include '../components/total_data.php'; ?>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-8">
                    <!-- Quick Add Food Form -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg card-hover fade-in">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">Quick Add Food</h2>
                            <span class="bg-green-100 text-green-600 px-4 py-1 rounded-full text-sm font-medium">Fast Entry</span>
                        </div>
                        <form id="addFoodForm" class="space-y-6">
                            <div class="space-y-2">
                                <label for="food_name" class="text-sm font-medium text-gray-700">Food Name</label>
                                <input type="text" id="food_name" name="food_name" 
                                    class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="Enter food name" required>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label for="protein" class="text-sm font-medium text-gray-700">Protein (grams)</label>
                                    <input type="number" id="protein" name="protein" step="0.1" 
                                        class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        placeholder="0.0" required>
                                </div>
                                <div class="space-y-2">
                                    <label for="calorie" class="text-sm font-medium text-gray-700">Calories</label>
                                    <input type="number" id="calorie" name="calorie" step="0.1" 
                                        class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        placeholder="0.0" required>
                                </div>
                            </div>
                            <button type="submit" 
                                class="w-full py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transform transition-all active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Add Food
                            </button>
                        </form>
                    </div>

                    <!-- Added Foods List -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg card-hover fade-in">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">Your Added Foods</h2>
                            <span class="bg-blue-100 text-blue-600 px-4 py-1 rounded-full text-sm font-medium">Today's Log</span>
                        </div>
                        <div class="space-y-4">
                            <?php if (!empty($userFoods)): ?>
                                <?php foreach ($userFoods as $food): ?>
                                    <div class="p-4 bg-gray-50 rounded-xl flex items-center justify-between">
                                        <div>
                                            <h3 class="font-medium text-gray-800"><?php echo htmlspecialchars($food['food_name']); ?></h3>
                                            <p class="text-sm text-gray-500">
                                                Protein: <span class="text-blue-600 font-medium"><?php echo htmlspecialchars($food['protein']); ?>g</span> • 
                                                Calories: <span class="text-green-600 font-medium"><?php echo htmlspecialchars($food['calorie']); ?> kcal</span>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-8">
                                    <p class="text-gray-500">No foods added yet.</p>
                                    <p class="text-sm text-gray-400 mt-2">Start tracking your nutrition by adding foods above!</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-8">
                    <!-- Search Nutrition Database -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg card-hover fade-in">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">Search Foods</h2>
                            <span class="bg-purple-100 text-purple-600 px-4 py-1 rounded-full text-sm font-medium">Database</span>
                        </div>
                        <div class="relative mb-6">
                            <input type="text" id="searchFood" 
                                class="w-full p-4 pl-12 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                placeholder="Search for foods...">
                            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <div id="nutritionResults" class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
                            <!-- Results will be populated here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Previous JavaScript remains the same, but let's enhance the nutritionResults template
            $('#searchFood').on('input', function() {
                const query = $(this).val();
                if (query.length > 1) {
                    $.ajax({
                        url: '../controller/search_nutrition.php',
                        method: 'GET',
                        data: { query },
                        success: function(response) {
                            const foods = JSON.parse(response);
                            let html = '';
                            if (Array.isArray(foods)) {
                                foods.forEach(food => {
                                    html += `
                                        <div class="p-4 bg-gray-50 rounded-xl flex items-center justify-between card-hover">
                                            <div>
                                                <h3 class="font-medium text-gray-800">${food.food_name}</h3>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    <span class="inline-flex items-center text-blue-600">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                        </svg>
                                                        ${food.protein}g protein
                                                    </span>
                                                    <span class="mx-2">•</span>
                                                    <span class="inline-flex items-center text-green-600">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                        </svg>
                                                        ${food.calorie} kcal
                                                    </span>
                                                </p>
                                            </div>
                                            <button 
                                                class="p-2 bg-green-500 text-white rounded-xl hover:bg-green-600 transform transition-all active:scale-95 addFoodButton" 
                                                data-name="${food.food_name}" 
                                                data-protein="${food.protein}" 
                                                data-calorie="${food.calorie}">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>`;
                                });
                                $('#nutritionResults').html(html);
                            } else {
                                $('#nutritionResults').html(`
                                    <div class="text-center py-8">
                                        <p class="text-gray-500">No results found</p>
                                        <p class="text-sm text-gray-400 mt-2">Try a different search term</p>
                                    </div>
                                `);
                            }
                        },
                        error: function() {
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
        $.ajax({
            url: 'food.php',
            method: 'POST',
            data: { food_name, protein, calorie },
            success: function (response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    alert('Food added successfully!');
                    location.reload(); // Refresh the page
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