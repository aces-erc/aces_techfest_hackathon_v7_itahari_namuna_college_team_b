<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Sidebar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <style>
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
        @keyframes slideOut {
            from { transform: translateX(0); }
            to { transform: translateX(-100%); }
        }
        .slide-in {
            animation: slideIn 0.3s forwards;
        }
        .slide-out {
            animation: slideOut 0.3s forwards;
        }
    </style>
</head>
<body class="font-sans bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <nav id="sidebar" class="bg-white shadow-xl h-screen fixed top-0 left-0 w-64 py-6 overflow-auto transition-all duration-300 ease-in-out z-50">
            <div class="relative flex flex-col h-full">
                <!-- Toggle Button -->
                <button id="sidebarToggle" class="absolute -right-3 top-4 bg-white rounded-full p-1 shadow-md hover:bg-gray-100 transition-colors duration-200">
                    <i class="uil uil-angle-left-b text-gray-600 text-xl"></i>
                </button>

                <!-- Logo -->
                <a href="dashboard.php" class="text-center mb-8">
                    <img src="https://via.placeholder.com/160x50?text=FitNepal" alt="FitNepal Logo" class='w-[160px] inline' />
                </a>

                <!-- Navigation Links -->
                <ul class="space-y-2 flex-1">
                    <li>
                        <a href="dashboard.php" class="text-sm flex items-center text-blue-600 border-r-4 border-blue-600 bg-blue-50 px-6 py-3 transition-all">
                            <i class="uil uil-dashboard w-5 h-5 mr-3"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="stats.php" class="text-gray-700 text-sm flex items-center hover:text-blue-600 hover:border-r-4 border-blue-600 hover:bg-blue-50 px-6 py-3 transition-all">
                            <i class="uil uil-dumbbell w-5 h-5 mr-3"></i>
                            <span>Workouts</span>
                        </a>
                    </li>
                    <li>
                        <a href="suggestion.php" class="text-gray-700 text-sm flex items-center hover:text-blue-600 hover:border-r-4 border-blue-600 hover:bg-blue-50 px-6 py-3 transition-all">
                            <i class="uil uil-lightbulb-alt w-5 h-5 mr-3"></i>
                            <span>Suggestion</span>
                        </a>
                    </li>
                    <li>
                        <a href="food.php" class="text-gray-700 text-sm flex items-center hover:text-blue-600 hover:border-r-4 border-blue-600 hover:bg-blue-50 px-6 py-3 transition-all">
                            <i class="uil uil-utensils w-5 h-5 mr-3"></i>
                            <span>Food Log</span>
                        </a>
                    </li>
                    <li>
                        <a href="profile.php" class="text-gray-700 text-sm flex items-center hover:text-blue-600 hover:border-r-4 border-blue-600 hover:bg-blue-50 px-6 py-3 transition-all">
                            <i class="uil uil-user w-5 h-5 mr-3"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="settings.php" class="text-gray-700 text-sm flex items-center hover:text-blue-600 hover:border-r-4 border-blue-600 hover:bg-blue-50 px-6 py-3 transition-all">
                            <i class="uil uil-setting w-5 h-5 mr-3"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="../includes/logout.php" class="text-gray-700 text-sm flex items-center hover:text-blue-600 hover:border-r-4 border-blue-600 hover:bg-blue-50 px-6 py-3 transition-all">
                            <i class="uil uil-signout w-5 h-5 mr-3"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const sidebarToggle = document.getElementById('sidebarToggle');
        let isSidebarOpen = true;

        sidebarToggle.addEventListener('click', () => {
            isSidebarOpen = !isSidebarOpen;
            if (isSidebarOpen) {
                sidebar.style.width = '256px';
                mainContent.style.marginLeft = '256px';
                sidebar.classList.remove('slide-out');
                sidebar.classList.add('slide-in');
                sidebarToggle.innerHTML = '<i class="uil uil-angle-left-b text-gray-600 text-xl"></i>';
            } else {
                sidebar.style.width = '0';
                mainContent.style.marginLeft = '0';
                sidebar.classList.remove('slide-in');
                sidebar.classList.add('slide-out');
                sidebarToggle.innerHTML = '<i class="uil uil-bars text-gray-600 text-xl"></i>';
            }
        });
    </script>
</body>
</html>