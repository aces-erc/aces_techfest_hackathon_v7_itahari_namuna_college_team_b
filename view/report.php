<?php
include_once '../config/db.php';
include_once '../includes/session.php';

// Check if the user has a "paid" status in `manual_pay`
$is_paid = false;
if (isset($_SESSION['user_id'])) {
    try {
        $stmt = $db->prepare("SELECT status FROM manual_pay WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([':user_id' => $_SESSION['user_id']]);
        $payment = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($payment && $payment['status'] === 'paid') {
            $is_paid = true;
        }
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
    }
}

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
        ORDER BY day
    ");
    $stmt->execute([':user_id' => $_SESSION['user_id']]);
    $workoutData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $daysInMonth = date('t');
    $workoutCounts = array_fill(1, $daysInMonth, 0);
    $nonWorkoutCounts = array_fill(1, $daysInMonth, 0);
    $cumulativeWorkouts = array_fill(1, $daysInMonth, 0);

    $totalWorkouts = 0;
    foreach ($workoutData as $entry) {
        if ($entry['status'] === 'workout') {
            $workoutCounts[$entry['day_number']]++;
            $totalWorkouts++;
        } elseif ($entry['status'] === 'notworkout') {
            $nonWorkoutCounts[$entry['day_number']]++;
        }
        $cumulativeWorkouts[$entry['day_number']] = $totalWorkouts;
    }

    $labels = range(1, $daysInMonth);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// Function to export data
function exportData($data) {
    $output = "Day,Status\n";
    foreach ($data as $entry) {
        $output .= "{$entry['day_number']},{$entry['status']}\n";
    }
    return $output;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Analytics - FitNepal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <?php include_once '../includes/sidebar.php'; ?>
    <div class="p-8 ml-64">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                Workout Analytics
                <span class="text-lg text-gray-600 ml-2"><?php echo date('F Y'); ?></span>
            </h1>
            <div class="flex space-x-4">
                <?php if ($is_paid): ?>
                    <button id="exportBtn" class="px-4 py-2 bg-white rounded-lg shadow hover:shadow-md transition-all duration-300 text-gray-700">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                <?php endif; ?>
                <button onclick="location.reload();" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:shadow-md transition-all duration-300">
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
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-dumbbell text-blue-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Rest Days</p>
                        <h3 class="text-2xl font-bold text-gray-800"><?php echo array_sum($nonWorkoutCounts); ?></h3>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-bed text-green-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Workout Streak</p>
                        <h3 class="text-2xl font-bold text-gray-800">
                            <?php
                            $streak = 0;
                            $maxStreak = 0;
                            foreach ($workoutCounts as $count) {
                                if ($count > 0) {
                                    $streak++;
                                    $maxStreak = max($maxStreak, $streak);
                                } else {
                                    $streak = 0;
                                }
                            }
                            echo $maxStreak;
                            ?>
                        </h3>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="fas fa-fire text-yellow-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Completion Rate</p>
                        <h3 class="text-2xl font-bold text-gray-800">
                            <?php
                            $completionRate = (array_sum($workoutCounts) / $daysInMonth) * 100;
                            echo number_format($completionRate, 1) . '%';
                            ?>
                        </h3>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <i class="fas fa-chart-pie text-purple-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Chart -->
        <div class="bg-white p-6 rounded-xl shadow-lg mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Monthly Progress</h2>
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
        const cumulativeData = <?php echo json_encode(array_values($cumulativeWorkouts)); ?>;

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
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1,
                        order: 2
                    },
                    {
                        label: 'Rest Days',
                        data: nonWorkoutData,
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 1,
                        order: 2
                    },
                    {
                        label: 'Cumulative Workouts',
                        data: cumulativeData,
                        type: 'line',
                        borderColor: 'rgba(245, 158, 11, 1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4,
                        order: 1
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
                        mode: 'index',
                        intersect: false,
                    },
                },
                scales: {
                    x: {
                        stacked: true,
                        title: {
                            display: true,
                            text: 'Days of the Month'
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    }
                }
            }
        });

        // Export functionality
        document.getElementById('exportBtn')?.addEventListener('click', function() {
            const data = <?php echo json_encode($workoutData); ?>;
            const csvContent = "data:text/csv;charset=utf-8," + <?php echo json_encode(exportData($workoutData)); ?>;
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "workout_data.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    </script>
</body>
</html>
