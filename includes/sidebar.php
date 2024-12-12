
<nav class="bg-white shadow-xl h-screen fixed top-0 left-0 min-w-[250px] py-6 font-[sans-serif] overflow-auto">
    <div class="relative flex flex-col h-full">
        <!-- Logo -->
        <a href="dashboard.php" class="text-center mb-8 item-center pl-12 ">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 100" class="32 h-16" style="min-width: 120px;">

<circle cx="40" cy="50" r="8" fill="#4F46E5">
  <animate attributeName="opacity" values="1;0.5;1" dur="2s" repeatCount="indefinite" />
</circle>
<circle cx="80" cy="30" r="8" fill="#4F46E5">
  <animate attributeName="opacity" values="0.5;1;0.5" dur="2s" repeatCount="indefinite" />
</circle>
<circle cx="80" cy="70" r="8" fill="#4F46E5">
  <animate attributeName="opacity" values="0.5;1;0.5" dur="2s" repeatCount="indefinite" />
</circle>
<circle cx="120" cy="50" r="8" fill="#4F46E5">
  <animate attributeName="opacity" values="1;0.5;1" dur="2s" repeatCount="indefinite" />
</circle>

<line x1="48" y1="50" x2="72" y2="30" stroke="#4F46E5" stroke-width="2">
  <animate attributeName="opacity" values="0.3;0.8;0.3" dur="2s" repeatCount="indefinite" />
</line>
<line x1="48" y1="50" x2="72" y2="70" stroke="#4F46E5" stroke-width="2">
  <animate attributeName="opacity" values="0.3;0.8;0.3" dur="2s" repeatCount="indefinite" />
</line>
<line x1="88" y1="30" x2="112" y2="50" stroke="#4F46E5" stroke-width="2">
  <animate attributeName="opacity" values="0.3;0.8;0.3" dur="2s" repeatCount="indefinite" />
</line>
<line x1="88" y1="70" x2="112" y2="50" stroke="#4F46E5" stroke-width="2">
  <animate attributeName="opacity" values="0.3;0.8;0.3" dur="2s" repeatCount="indefinite" />
</line>

<rect x="140" y="45" width="20" height="10" rx="2" fill="#7C3AED">
  <animate attributeName="transform" attributeType="XML" type="rotate" 
    from="0 150 50" to="360 150 50" dur="4s" repeatCount="indefinite" />
</rect>
<circle cx="135" cy="50" r="6" fill="#7C3AED">
  <animate attributeName="transform" attributeType="XML" type="rotate" 
    from="0 150 50" to="360 150 50" dur="4s" repeatCount="indefinite" />
</circle>
<circle cx="165" cy="50" r="6" fill="#7C3AED">
  <animate attributeName="transform" attributeType="XML" type="rotate" 
    from="0 150 50" to="360 150 50" dur="4s" repeatCount="indefinite" />
</circle>

<text x="10" y="70" font-family="Arial" font-size="18" fill="#4F46E5">AI</text>
<text x="100" y="20" font-family="Arial" font-size="14" fill="#7C3AED">GYANFIT</text>
</svg>
        </a>

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