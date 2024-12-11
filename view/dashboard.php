<?php
include_once '../config/db.php';
include_once '../includes/session.php'; // Include session file to handle authentication

// Fetch user data from the database
try {
    $stmt = $db->prepare("
        SELECT 
            u.full_name, u.age, u.weight, u.height, u.weekly_activities, 
            bs.bmi, bs.protein_goal, bs.calories_goal, bs.weight_recommendation, bs.weight_goal
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

// Function to determine activity level
function getActivityLevel($activities) {
    $count = count(explode(',', $activities));
    if ($count <= 2) return ['level' => 'Normal', 'color' => 'green'];
    if ($count <= 4) return ['level' => 'Average', 'color' => 'orange'];
    return ['level' => 'High', 'color' => 'red'];
}

$activityInfo = getActivityLevel($user['weekly_activities']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Teko:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Teko', sans-serif;
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

    <!-- Sidebar -->
    <?php include_once '../includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="ml-[250px] p-6 min-h-screen relative">
        <div class="max-w-7xl mx-auto">
            <!-- Activity Indicator -->
            <div class="absolute top-4 right-4 fade-in" style="animation-delay: 0.2s;">
                <div class="flex items-center bg-white rounded-full shadow-lg px-4 py-2">
                    <span class="text-lg font-semibold mr-2">Activity Level:</span>
                    <span class="inline-block w-3 h-3 rounded-full mr-2 bg-<?php echo $activityInfo['color']; ?>-500"></span>
                    <span class="text-lg font-bold text-<?php echo $activityInfo['color']; ?>-500"><?php echo $activityInfo['level']; ?></span>
                </div>
            </div>

            <h1 class="text-4xl font-bold text-blue-800 mb-8 fade-in">Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <?php
                $cards = [
                    ['title' => 'Your BMI', 'value' => $user['bmi'], 'unit' => '', 'decimals' => 2],
                    ['title' => 'Protein Goal', 'value' => $user['protein_goal'], 'unit' => 'g/day', 'decimals' => 2],
                    ['title' => 'Calories Goal', 'value' => $user['calories_goal'], 'unit' => 'kcal/day', 'decimals' => 2],
                    ['title' => 'Recommended Weight', 'value' => $user['weight_recommendation'], 'unit' => 'kg', 'decimals' => 2],
                    ['title' => 'Current Weight', 'value' => $user['weight'], 'unit' => 'kg', 'decimals' => 2],
                    ['title' => 'Goal Weight', 'value' => $user['weight_goal'], 'unit' => 'kg', 'decimals' => 2],
                ];

                foreach ($cards as $index => $card):
                ?>
                <div class="bg-white rounded-lg shadow-lg p-6 transition-all duration-300 ease-in-out hover:shadow-xl fade-in" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                    <h2 class="text-2xl font-semibold text-blue-700"><?php echo $card['title']; ?></h2>
                    <p class="text-4xl font-bold text-gray-800 mt-2 overflow-hidden">
                        <?php 
                        $formattedValue = number_format($card['value'], $card['decimals']);
                        foreach (str_split($formattedValue) as $char):
                        ?>
                            <span class="animate-number" style="animation-delay: <?php echo $index * 0.1 + 0.5; ?>s;">
                                <?php echo $char; ?>
                            </span>
                        <?php endforeach; ?>
                        <?php if ($card['unit']): ?>
                            <span class="text-2xl ml-1 animate-number" style="animation-delay: <?php echo $index * 0.1 + 0.7; ?>s;">
                                <?php echo $card['unit']; ?>
                            </span>
                        <?php endif; ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Weekly Activities -->
            <div class="bg-white rounded-lg shadow-lg p-6 transition-all duration-300 ease-in-out hover:shadow-xl fade-in" style="animation-delay: 0.6s;">
                <h2 class="text-2xl font-semibold text-blue-700 mb-4">Weekly Activities</h2>
                <div class="flex flex-wrap">
                    <?php 
                    $activities = explode(',', $user['weekly_activities']);
                    foreach ($activities as $index => $activity):
                    ?>
                        <span class="inline-block bg-blue-100 text-blue-800 rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2 transition-all duration-300 ease-in-out hover:bg-blue-200 hover:shadow-md fade-in" style="animation-delay: <?php echo 0.7 + $index * 0.1; ?>s;">
                            <?php echo trim($activity); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
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

        // Trigger animation when the page loads
        animateNumbers();

        // Trigger animation when scrolling (if needed)
        window.addEventListener('scroll', () => {
            animateNumbers();
        });
    });
    </script>
</body>
</html>