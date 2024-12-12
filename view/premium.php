<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pricing Plans</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #1e293b;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            padding: 20px;
            color: white;
        }

        .sidebar h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 10px;
            border-radius: 6px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #334155;
        }

        .tick-icon {
            color: #16a34a; /* Light green color */
            margin-right: 10px;
        }
    </style>
</head>
<body class="bg-gray-100">
<?php include '../includes/sidebar.php'; ?>


<div class="ml-[250px] p-6 min-h-screen">
    <div class="max-w-5xl mx-auto font-[sans-serif]">
        <div class="text-center">
            <h2 class="text-gray-800 text-4xl font-bold">Pricing Plans</h2>
            <p class="text-gray-600 text-lg mt-4">Choose the best plan that suits your needs!</p>
        </div>

        <div class="grid lg:grid-cols-2 md:grid-cols-2 gap-8 mt-12">
            <!-- Free Plan -->
            <div class="bg-gray-100 rounded-3xl overflow-hidden p-8 shadow-lg">
                <div class="text-left">
                    <h4 class="text-gray-800 font-semibold text-2xl">Free</h4>
                    <p class="text-gray-600 text-sm mt-2">Perfect for individuals.</p>
                    <h3 class="text-gray-800 font-semibold text-2xl mt-4">Rs. 0</h3>
                    <button class="w-full mt-8 px-5 py-2.5 text-sm bg-gray-500 text-white rounded-full cursor-not-allowed">Free</button>
                </div>
                <div class="mt-8">
                    <h4 class="text-gray-800 font-semibold text-lg mb-4">Plan Includes</h4>
                    <ul class="space-y-4">
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle tick-icon"></i> Analytics
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle tick-icon"></i> Weekly Reports
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle tick-icon"></i> SMS Alerts
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle tick-icon"></i> 100 Nutrition Data
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Pro Plan -->
            <div class="bg-white lg:scale-[1.05] shadow-[0_2px_40px_-4px_rgba(93,96,127,0.2)] rounded-3xl overflow-hidden p-8">
                <div class="text-left">
                    <h4 class="text-gray-800 font-semibold text-2xl">Pro</h4>
                    <p class="text-gray-600 text-sm mt-2">Great for professionals.</p>
                    <h3 class="text-gray-800 font-semibold text-2xl mt-4">Rs. 100 (Lifetime)</h3>
                    <form action="checkout.php" method="POST">
                        <input type="hidden" name="plan" value="Pro">
                        <input type="hidden" name="price" value="100">
                        <button type="submit" class="w-full mt-8 px-5 py-2.5 text-sm bg-blue-600 text-white hover:bg-blue-700 rounded-full">Buy Now</button>
                    </form>
                </div>
                <div class="mt-8">
                    <h4 class="text-gray-800 font-semibold text-lg mb-4">Plan Includes</h4>
                    <ul class="space-y-4">
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle tick-icon"></i> AI Suggestions
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle tick-icon"></i> 1000+ Nutrition Data
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle tick-icon"></i> Analytics
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle tick-icon"></i> Weekly and Monthly Reports
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle tick-icon"></i> SMS Alerts
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
