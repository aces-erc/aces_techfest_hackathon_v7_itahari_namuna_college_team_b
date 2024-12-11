<?php
include_once '../config/db.php';
include_once '../includes/session.php';

// Fetch user data from the database
try {
    $stmt = $db->prepare("
        SELECT 
            u.full_name, u.age, u.weight, u.height, u.weekly_activities, u.consumed_protein, 
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

// Determine daily protein progress and reset logic
$currentDate = date('Y-m-d');
$proteinPercentage = min(100, round(($user['consumed_protein'] / $user['protein_goal']) * 100));
$status = $proteinPercentage >= 100 ? 'completed' : 'incompleted';

// Check if a record exists for today's date
$checkProgress = $db->prepare("
    SELECT * FROM protein_progress 
    WHERE user_id = :user_id AND Date = :date
");
$checkProgress->execute([
    ':user_id' => $_SESSION['user_id'],
    ':date' => $currentDate
]);

if ($checkProgress->rowCount() === 0) {
    // Insert today's progress
    $insertProgress = $db->prepare("
        INSERT INTO protein_progress (user_id, Date, status, completed_percentage)
        VALUES (:user_id, :date, :status, :completed_percentage)
    ");
    $insertProgress->execute([
        ':user_id' => $_SESSION['user_id'],
        ':date' => $currentDate,
        ':status' => $status,
        ':completed_percentage' => $proteinPercentage
    ]);

    // Reset consumed protein for a new day
    $resetProtein = $db->prepare("
        UPDATE users 
        SET consumed_protein = 0 
        WHERE user_id = :user_id
    ");
    $resetProtein->execute([':user_id' => $_SESSION['user_id']]);

    // Update the user's consumed protein in the PHP object
    $user['consumed_protein'] = 0;
}

function getActivityLevel($activities) {
    $count = count(explode(',', $activities));
    if ($count <= 2) return ['level' => 'Normal', 'color' => 'green'];
    if ($count <= 4) return ['level' => 'Average', 'color' => 'yellow'];
    return ['level' => 'High', 'color' => 'red'];
}

$activityInfo = getActivityLevel($user['weekly_activities']);
$dailyProtein = $user['protein_goal'] - $user['consumed_protein'];
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
        body { font-family: 'Inter', sans-serif; }
        .fade-in { animation: fadeIn 0.5s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <?php include_once '../includes/sidebar.php'; ?>

    <div class="ml-[250px] p-6 min-h-screen">
        <h1 class="text-3xl font-bold text-blue-800 mb-8 fade-in">Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold text-blue-700 mb-4">Protein Goal Progress</h2>
                <div style="height: 200px; position: relative;">
                    <canvas id="proteinChart"></canvas>
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                        <p class="text-3xl font-bold text-blue-600"><?php echo $proteinPercentage; ?>%</p>
                        <p class="text-sm text-gray-500">Completed</p>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <p>Daily Goal: <?php echo $user['protein_goal']; ?>g</p>
                    <p>Consumed: <?php echo $user['consumed_protein']; ?>g</p>
                    <p>Remaining: <?php echo max(0, $dailyProtein); ?>g</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('proteinChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [<?php echo $proteinPercentage; ?>, <?php echo 100 - $proteinPercentage; ?>],
                    backgroundColor: ['#3B82F6', '#E5E7EB']
                }]
            },
            options: {
                cutout: '80%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    </script>
</body>
</html>
