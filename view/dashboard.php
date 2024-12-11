<?php
include_once '../config/db.php';
include_once '../includes/session.php';

// Fetch user data from the database
try {
    $stmt = $db->prepare("
        SELECT 
            u.user_id, u.full_name, u.age, u.weight, u.height, u.weekly_activities, u.consumed_protein, 
            bs.bmi, bs.protein_goal, bs.calories_goal, bs.weight_recommendation
        FROM users u
        LEFT JOIN body_stats bs ON u.user_id = bs.user_id
        WHERE u.user_id = :user_id
    ");
    $stmt->execute([':user_id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("User not found.");
    }
} catch (Exception $e) {
    die("Error fetching user data: " . $e->getMessage());
}

// Insert daily protein progress if not logged already
try {
    $currentDate = date('Y-m-d');

    // Check if today's progress is already logged
    $checkProgress = $db->prepare("
        SELECT * FROM protein_progress 
        WHERE user_id = :user_id AND Date = :date
    ");
    $checkProgress->execute([
        ':user_id' => $user['user_id'],
        ':date' => $currentDate
    ]);

    if ($checkProgress->rowCount() === 0) {
        // Calculate completion percentage
        $proteinPercentage = round(($user['consumed_protein'] / $user['protein_goal']) * 100);
        $status = $proteinPercentage >= 100 ? 'completed' : 'incompleted';

        // Insert today's progress
        $insertProgress = $db->prepare("
            INSERT INTO protein_progress (user_id, Date, status, completed_percentage)
            VALUES (:user_id, :date, :status, :completed_percentage)
        ");
        $insertProgress->execute([
            ':user_id' => $user['user_id'],
            ':date' => $currentDate,
            ':status' => $status,
            ':completed_percentage' => min($proteinPercentage, 100) // Cap at 100%
        ]);

        // Reset consumed protein for the next day
        $resetProtein = $db->prepare("
            UPDATE users SET consumed_protein = 0 WHERE user_id = :user_id
        ");
        $resetProtein->execute([':user_id' => $user['user_id']]);
    }
} catch (Exception $e) {
    die("Error managing daily protein progress: " . $e->getMessage());
}

function getActivityLevel($activities) {
    $count = count(explode(',', $activities));
    if ($count <= 2) return ['level' => 'Normal', 'color' => 'green'];
    if ($count <= 4) return ['level' => 'Average', 'color' => 'yellow'];
    return ['level' => 'High', 'color' => 'red'];
}

$activityInfo = getActivityLevel($user['weekly_activities']);

$dailyProtein = $user['protein_goal'] - $user['consumed_protein'];
$proteinPercentage = min(100, round(($user['consumed_protein'] / $user['protein_goal']) * 100));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes numberChange {
            0% { transform: translateY(100%); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        .animate-number {
            display: inline-block;
            animation: numberChange 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <?php include_once '../includes/sidebar.php'; ?>

    <div class="ml-[250px] p-6 min-h-screen relative">
        <div class="max-w-7xl mx-auto">
            <div class="absolute top-4 right-4 fade-in" style="animation-delay: 0.2s;">
                <div class="flex items-center bg-white rounded-full shadow-lg px-4 py-2">
                    <span class="text-sm font-semibold mr-2">Activity Level:</span>
                    <span class="inline-block w-3 h-3 rounded-full mr-2 bg-<?php echo $activityInfo['color']; ?>-500"></span>
                    <span class="text-sm font-bold text-<?php echo $activityInfo['color']; ?>-500"><?php echo $activityInfo['level']; ?></span>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-blue-800 mb-8 fade-in">Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="col-span-1 md:col-span-2 lg:col-span-1 bg-white rounded-lg shadow-lg p-6 transition-all duration-300 ease-in-out hover:shadow-xl fade-in" style="animation-delay: 0.3s;">
                    <h2 class="text-xl font-semibold text-blue-700 mb-4">Protein Goal Progress</h2>
                    <div class="relative" style="height: 200px;">
                        <canvas id="proteinChart"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center flex-col">
                            <span class="text-3xl font-bold text-blue-600"><?php echo $proteinPercentage; ?>%</span>
                            <span class="text-sm text-gray-500">Completed</span>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600">Daily Goal: <?php echo $user['protein_goal']; ?>g</p>
                        <p class="text-sm text-gray-600">Consumed: <?php echo $user['consumed_protein']; ?>g</p>
                        <p class="text-sm font-semibold text-blue-600">Remaining: <?php echo $dailyProtein; ?>g</p>
                    </div>
                </div>

                <?php
                $cards = [
                    ['title' => 'Your BMI', 'value' => $user['bmi'], 'unit' => '', 'decimals' => 2],
                    ['title' => 'Calories Goal', 'value' => $user['calories_goal'], 'unit' => 'kcal/day', 'decimals' => 0],
                    ['title' => 'Recommended Weight', 'value' => $user['weight_recommendation'], 'unit' => 'kg', 'decimals' => 1],
                    ['title' => 'Current Weight', 'value' => $user['weight'], 'unit' => 'kg', 'decimals' => 1],
                ];

                foreach ($cards as $index => $card):
                ?>
                <div class="bg-white rounded-lg shadow-lg p-6 transition-all duration-300 ease-in-out hover:shadow-xl fade-in" style="animation-delay: <?php echo ($index + 2) * 0.1; ?>s;">
                    <h2 class="text-lg font-semibold text-blue-700 mb-2"><?php echo $card['title']; ?></h2>
                    <p class="text-3xl font-bold text-gray-800 mt-2 overflow-hidden">
                        <?php 
                        $formattedValue = number_format($card['value'], $card['decimals']);
                        foreach (str_split($formattedValue) as $char):
                        ?>
                            <span class="animate-number" style="animation-delay: <?php echo ($index + 2) * 0.1 + 0.5; ?>s;">
                                <?php echo $char; ?>
                            </span>
                        <?php endforeach; ?>
                        <?php if ($card['unit']): ?>
                            <span class="text-xl ml-1 animate-number" style="animation-delay: <?php echo ($index + 2) * 0.1 + 0.7; ?>s;">
                                <?php echo $card['unit']; ?>
                            </span>
                        <?php endif; ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const animateNumbers = () => {
            document.querySelectorAll('.animate-number').forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 50);
            });
        };

        animateNumbers();

        window.addEventListener('scroll', () => {
            animateNumbers();
        });

        // Protein Goal Chart
        const ctx = document.getElementById('proteinChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [<?php echo $proteinPercentage; ?>, <?php echo 100 - $proteinPercentage; ?>],
                    backgroundColor: ['#3B82F6', '#E5E7EB'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '80%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: false
                    }
                }
            }
        });
    });
    </script>
</body>
</html>


