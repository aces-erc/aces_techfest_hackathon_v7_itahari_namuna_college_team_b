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
  

<?php include 'navbar.php'; ?>
<section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-white -z-10"></div>
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8 animate-float">
                    <h1 class="text-5xl md:text-6xl font-bold leading-tight gradient-text">
                        Transform Your Fitness Journey
                    </h1>
                    <p class="text-xl text-gray-600">
                        Track, analyze, and improve your fitness with our intelligent platform. Join thousands of users achieving their health goals.
                    </p>
                    <div class="flex flex-wrap gap-4">
                     <a href="signup.php">   <button class="px-8 py-4 rounded-full bg-gradient-to-r from-indigo-600 to-indigo-700 text-white hover:opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Get Started Free
                        </button>
                    </a>
                        <button class="px-8 py-4 rounded-full gradient-border text-indigo-600 hover:bg-indigo-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Watch Demo
                        </button>
                    </div>
                </div>
                <div class="relative">
                    <!-- Insert the SVG here -->
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/5 to-indigo-700/5 rounded-3xl transform rotate-6"></div>
                    <div class="relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 600">
    <!-- Neural Network Background -->
    <g class="network-bg">
        <circle cx="200" cy="150" r="3" fill="#4F46E5">
            <animate attributeName="opacity"
                     values="0.3;0.7;0.3"
                     dur="2s"
                     repeatCount="indefinite"/>
        </circle>
        <circle cx="400" cy="100" r="3" fill="#4F46E5">
            <animate attributeName="opacity"
                     values="0.7;0.3;0.7"
                     dur="2.5s"
                     repeatCount="indefinite"/>
        </circle>
        <circle cx="600" cy="200" r="3" fill="#4F46E5">
            <animate attributeName="opacity"
                     values="0.5;0.8;0.5"
                     dur="3s"
                     repeatCount="indefinite"/>
        </circle>
        <!-- Connecting Lines -->
        <path d="M200,150 L400,100 L600,200" 
              stroke="#4F46E5" 
              stroke-width="1" 
              fill="none" 
              opacity="0.2">
            <animate attributeName="opacity"
                     values="0.2;0.4;0.2"
                     dur="3s"
                     repeatCount="indefinite"/>
        </path>
    </g>

    <!-- Central Fitness Data Circle -->
    <circle cx="400" cy="300" r="120" 
            fill="none" 
            stroke="#4F46E5" 
            stroke-width="2">
        <animate attributeName="r"
                 values="120;125;120"
                 dur="4s"
                 repeatCount="indefinite"/>
    </circle>

    <!-- Rotating Tech Ring -->
    <g transform="translate(400, 300)">
        <circle r="150" 
                fill="none" 
                stroke="#818CF8" 
                stroke-width="1" 
                stroke-dasharray="30 10">
            <animateTransform attributeName="transform"
                            type="rotate"
                            from="0"
                            to="360"
                            dur="20s"
                            repeatCount="indefinite"/>
        </circle>
    </g>

    <!-- AI Data Visualization Elements -->
    <g transform="translate(400, 300)">
        <!-- Pulse Wave -->
        <path d="M-100,0 L-60,0 L-40,-30 L-20,30 L0,0 L40,0"
              fill="none"
              stroke="#4F46E5"
              stroke-width="3"
              stroke-linecap="round">
            <animate attributeName="d"
                     values="M-100,0 L-60,0 L-40,-30 L-20,30 L0,0 L40,0;
                             M-100,0 L-60,0 L-40,30 L-20,-30 L0,0 L40,0;
                             M-100,0 L-60,0 L-40,-30 L-20,30 L0,0 L40,0"
                     dur="2s"
                     repeatCount="indefinite"/>
        </path>
    </g>

    <!-- Animated Fitness Icons -->

    <g transform="translate(400, 300)">
        <!-- Dumbbell Icon -->
        <g transform="translate(-60, -60) scale(0.8)">
            <rect x="-40" y="-5" width="80" height="10" rx="5" fill="#4F46E5">
                <animate attributeName="opacity"
                         values="0.6;1;0.6"
                         dur="3s"
                         repeatCount="indefinite"/>
            </rect>
            <circle cx="-45" cy="0" r="15" fill="#4F46E5"/>
            <circle cx="45" cy="0" r="15" fill="#4F46E5"/>
        </g>

        <!-- Heart Rate Icon -->
        <g transform="translate(60, -60) scale(0.8)">
            <path d="M-20,0 L-10,0 L0,-10 L10,10 L20,0"
                  stroke="#4F46E5"
                  stroke-width="3"
                  fill="none"
                  stroke-linecap="round">
                <animate attributeName="stroke-width"
                         values="3;4;3"
                         dur="1s"
                         repeatCount="indefinite"/>
            </path>
        </g>

        <!-- Running Figure -->
        <g transform="translate(0, 60) scale(0.8)">
            <path d="M-10,0 C-5,-10 5,-10 10,0"
                  stroke="#4F46E5"
                  stroke-width="3"
                  fill="none"
                  stroke-linecap="round">
                <animate attributeName="d"
                         values="M-10,0 C-5,-10 5,-10 10,0;
                                 M-10,0 C-5,10 5,10 10,0;
                                 M-10,0 C-5,-10 5,-10 10,0"
                         dur="1s"
                         repeatCount="indefinite"/>
            </path>
            <circle cx="0" cy="-20" r="8" fill="#4F46E5"/>
        </g>
    </g>

    <!-- AI Processing Lines -->
    <g transform="translate(400, 300)">
        <g transform="rotate(45)">
            <line x1="-180" y1="0" x2="180" y2="0" 
                  stroke="#818CF8" 
                  stroke-width="1" 
                  stroke-dasharray="4 4">
                <animate attributeName="stroke-dashoffset"
                         values="0;16"
                         dur="1s"
                         repeatCount="indefinite"/>
            </line>
        </g>
        <g transform="rotate(-45)">
            <line x1="-180" y1="0" x2="180" y2="0" 
                  stroke="#818CF8" 
                  stroke-width="1" 
                  stroke-dasharray="4 4">
                <animate attributeName="stroke-dashoffset"
                         values="0;16"
                         dur="1s"
                         repeatCount="indefinite"/>
            </line>
        </g>
    </g>

    <!-- Data Points -->
    <g transform="translate(400, 300)">
        <circle cx="0" cy="-150" r="4" fill="#4F46E5">
            <animate attributeName="r"
                     values="4;6;4"
                     dur="2s"
                     repeatCount="indefinite"/>
        </circle>
        <circle cx="150" cy="0" r="4" fill="#4F46E5">
            <animate attributeName="r"
                     values="4;6;4"
                     dur="2s"
                     repeatCount="indefinite"
                     begin="0.5s"/>
        </circle>
        <circle cx="0" cy="150" r="4" fill="#4F46E5">
            <animate attributeName="r"
                     values="4;6;4"
                     dur="2s"
                     repeatCount="indefinite"
                     begin="1s"/>
        </circle>
        <circle cx="-150" cy="0" r="4" fill="#4F46E5">
            <animate attributeName="r"
                     values="4;6;4"
                     dur="2s"
                     repeatCount="indefinite"
                     begin="1.5s"/>
        </circle>
    </g>
</svg>
                    </div>
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