<?php
include_once '../config/db.php';

// Handle AJAX search request
if (isset($_GET['ajax_search'])) {
    $search_query = $_GET['search'] ?? '';
    try {
        $stmt = $db->prepare("SELECT * FROM nutrition WHERE food_name LIKE :search");
        $stmt->bindValue(':search', '%' . $search_query . '%');
        $stmt->execute();
        $foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($foods);
        exit;
    } catch(PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Nutrition List - FitNepal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .search-container {
            position: relative;
            max-width: 800px;
            margin: 2rem auto;
        }
        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6B7280;
        }
        .search-input {
            padding-left: 3rem;
        }
    </style>
</head>
<body class="bg-blue-200 min-h-screen">
<?php include  'navbar.php'; ?>
    <div class="pt-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="search-container">
            <i class="uil uil-search search-icon"></i>
            <input type="text" 
                   id="search" 
                   placeholder="Search for food..." 
                   class="search-input w-full p-4 rounded-full border-none focus:outline-none focus:ring-2 focus:ring-purple-500 text-gray-800 text-lg shadow-lg">
        </div>
        
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mt-8">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Food Name</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Calories</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Protein (g)</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Carbs (g)</th>
                            </tr>
                        </thead>
                        <tbody id="foodList" class="bg-white divide-y divide-gray-200">
                            <!-- Food items will be dynamically inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('search');
        const foodList = document.getElementById('foodList');

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function formatNumber(num) {
            return Number(num).toFixed(2);
        }

        function searchFoods() {
            const searchTerm = searchInput.value;
            fetch(`food.php?ajax_search=1&search=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    foodList.innerHTML = '';
                    data.forEach(food => {
                        const row = `
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${food.food_name}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${formatNumber(food.calorie)}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${formatNumber(food.protein)}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${formatNumber(food.carbs)}</td>
                            </tr>
                        `;
                        foodList.innerHTML += row;
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    foodList.innerHTML = `
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-red-500">
                                Error loading data. Please try again.
                            </td>
                        </tr>
                    `;
                });
        }

        const debouncedSearch = debounce(searchFoods, 300);

        searchInput.addEventListener('input', debouncedSearch);

        // Initial load
        searchFoods();
    </script>
</body>
</html>