<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Fitness Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4F46E5;
            --secondary-color: #818CF8;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes slideDown {
            from { transform: translateY(-100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-pulse-slow {
            animation: pulse 2s ease-in-out infinite;
        }

        .nav-item {
            position: relative;
        }

        .nav-item::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: white;
            transition: width 0.3s ease;
        }

        .nav-item:hover::after {
            width: 100%;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card-gradient {
            background: linear-gradient(135deg, #4F46E5 0%, #818CF8 100%);
        }

        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .mobile-menu.active {
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
  

<?php include 'Home/navbar.php'; ?>
    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8 animate-float">
                    <h1 class="text-5xl md:text-6xl font-bold leading-tight bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                        Transform Your Fitness Journey
                    </h1>
                    <p class="text-xl text-gray-600">
                        Track, analyze, and improve your fitness with our intelligent platform. Join thousands of users achieving their health goals.
                    </p>
                    <div class="flex space-x-4">
                        <button class="px-8 py-4 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Get Started Free
                        </button>
                        <button class="px-8 py-4 rounded-full bg-white text-indigo-600 hover:bg-indigo-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Watch Demo
                        </button>
                    </div>
                </div>
                <div class="relative animate-float">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl transform rotate-6 animate-pulse-slow"></div>
                    <img src="Home/images/firimg.png" alt="Fitness Dashboard" class="relative rounded-3xl shadow-2xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Cards -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-100">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature Card 1 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center mb-6">
                    <i class="fas fa-heart text-2xl text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4">Health Tracking</h3>
                <p class="text-gray-600">Monitor your vital signs and health metrics in real-time with our advanced tracking system.</p>
            </div>

            <!-- Feature Card 2 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center mb-6">
                    <i class="fas fa-dumbbell text-2xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4">Workout Plans</h3>
                <p class="text-gray-600">Personalized workout plans adapted to your goals and fitness level.</p>
            </div>

            <!-- Feature Card 3 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-14 h-14 rounded-full bg-pink-100 flex items-center justify-center mb-6">
                    <i class="fas fa-chart-line text-2xl text-pink-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4">Progress Analytics</h3>
                <p class="text-gray-600">Track your progress with detailed analytics and insights to optimize your performance.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-indigo-900 to-purple-900 text-white py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="space-y-4">
                <h3 class="text-2xl font-bold">FitFlow</h3>
                <p class="text-gray-300">Your complete fitness companion for a healthier lifestyle.</p>
            </div>
            <div class="space-y-4">
                <h4 class="text-lg font-semibold">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">Home</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">About</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">About</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">Features</a></li>
                </ul>
            </div>
            <div class="space-y-4">
                <h4 class="text-lg font-semibold">Support</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">Help Center</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">Privacy Policy</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">Terms of Service</a></li>
                </ul>
            </div>
            <div class="space-y-4">
                <h4 class="text-lg font-semibold">Connect</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto pt-8 mt-8 border-t border-gray-700">
            <p class="text-center text-gray-300">© 2024 FitFlow. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>