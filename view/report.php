<?php
include_once '../config/db.php'; // Include database connection
include_once '../includes/session.php';

// Fetch workout stats for the current month
try {
    $stmt = $db->prepare("
        SELECT 
            DAY(day) AS day_number, 
            status 
        FROM user_workout_calendar 
        WHERE user_id = :user_id
        AND MONTH(day) = MONTH(CURRENT_DATE())
        AND YEAR(day) = YEAR(CURRENT_DATE())
    ");
    $stmt->execute([':user_id' => $_SESSION['user_id']]);
    $workoutData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize arrays for workout and non-workout counts
    $daysInMonth = date('t'); // Total days in the current month
    $workoutCounts = array_fill(1, $daysInMonth, 0); // Workout days
    $nonWorkoutCounts = array_fill(1, $daysInMonth, 0); // Non-workout days

    // Populate the arrays with data
    foreach ($workoutData as $entry) {
        if ($entry['status'] === 'workout') {
            $workoutCounts[$entry['day_number']]++;
        } elseif ($entry['status'] === 'notworkout') {
            $nonWorkoutCounts[$entry['day_number']]++;
        }
    }

    // Generate day labels for the chart
    $labels = [];
    for ($i = 1; $i <= $daysInMonth; $i++) {
        $labels[] = "Day $i";
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Report</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <?php include_once '../includes/sidebar.php'; ?>
    <div class="p-8 ml-64">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-800">
                Workout Statistics
                <span class="text-lg text-gray-600 ml-2"><?php echo date('F Y'); ?></span>
            </h1>
            <div class="flex space-x-4">
                <button class="px-4 py-2 bg-white rounded-lg shadow hover:shadow-md transition-all duration-300 text-gray-700">
                    <i class="fas fa-download mr-2"></i>Export
                </button>
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:shadow-md transition-all duration-300">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Total Workouts</p>
                        <h3 class="text-2xl font-bold text-gray-800"><?php echo array_sum($workoutCounts); ?></h3>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-dumbbell text-green-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Total Rest Days</p>
                        <h3 class="text-2xl font-bold text-gray-800"><?php echo array_sum($nonWorkoutCounts); ?></h3>
                    </div>
                    <div class="p-3 bg-red-100 rounded-full">
                        <i class="fas fa-moon text-red-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Chart -->
        <div class="bg-white p-6 rounded-xl shadow-lg mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Monthly Progress</h2>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-sm bg-gray-100 rounded hover:bg-gray-200 transition-all duration-300">Week</button>
                    <button class="px-3 py-1 text-sm bg-indigo-600 text-white rounded">Month</button>
                    <button class="px-3 py-1 text-sm bg-gray-100 rounded hover:bg-gray-200 transition-all duration-300">Year</button>
                </div>
            </div>
            <div class="h-96">
                <canvas id="workoutChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Prepare the data for Chart.js
        const labels = <?php echo json_encode($labels); ?>;
        const workoutData = <?php echo json_encode(array_values($workoutCounts)); ?>;
        const nonWorkoutData = <?php echo json_encode(array_values($nonWorkoutCounts)); ?>;

        // Create the chart
        const ctx = document.getElementById('workoutChart').getContext('2d');
        const workoutChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Workout Days',
                        data: workoutData,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Non-Workout Days',
                        data: nonWorkoutData,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        enabled: true,
                    },
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Days of the Month'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>

