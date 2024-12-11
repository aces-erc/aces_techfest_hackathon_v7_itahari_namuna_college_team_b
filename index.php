

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Fitness Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>

        :root {
            --primary-color: #007bff;
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .animate-slideIn {
            animation: slideIn 0.6s ease-out forwards;
        }

        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .menu-btn {
            display: none;
        }

        @media (max-width: 768px) {
            .menu-btn {
                display: block;
            }

            .nav-links {
                display: none;
            }

            .nav-links.active {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 80px;
                left: 0;
                right: 0;
                background: var(--primary-color);
                padding: 20px;
                z-index: 50;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <header class="bg-gradient-to-r from-blue-500 to-primary-color text-white py-4 px-6 fixed w-full top-0 z-50 shadow-lg animate-slideIn">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="https://via.placeholder.com/40" alt="Logo" class="w-10 h-10 rounded-full">
                <h1 class="text-2xl font-bold">MyFitness</h1>
            </div>

            <!-- Mobile Menu Button -->
            <button class="menu-btn lg:hidden">
                <i class="fas fa-bars text-2xl"></i>
            </button>

            <!-- Navigation Links -->
            <nav class="nav-links hidden lg:flex items-center space-x-8">
                <a href="#" class="hover:text-blue-200 transition-colors duration-300">Home</a>
                <a href="#" class="hover:text-blue-200 transition-colors duration-300">Explore</a>
                <a href="#" class="hover:text-blue-200 transition-colors duration-300">Contact</a>
                <a href="#" class="hover:text-blue-200 transition-colors duration-300">Dashboard</a>
                <div class="flex space-x-4">
                    <button class="bg-white text-primary-color px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors duration-300">
                        Login
                    </button>
                    <button class="bg-primary-color text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-300">
                        Sign Up
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="pt-24 pb-12 px-6 animate-fadeIn">
        <div class="max-w-7xl mx-auto mt-16 grid lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h2 class="text-5xl font-bold text-gray-800 leading-tight">Stay Fit, Stay Motivated</h2>
                <p class="text-gray-600 text-lg">Track your progress, set goals, and achieve the fitness journey you deserve with our modern tools and insights.</p>
                <button class="bg-primary-color text-white px-8 py-3 rounded-lg hover:bg-blue-600 transition-colors duration-300">
                    Get Started
                </button>
            </div>
            <div class="relative">
                <img src="https://via.placeholder.com/600x400" alt="Fitness" class="rounded-xl shadow-2xl">
            </div>
        </div>
    </section>

    <!-- Dashboard Cards -->
    <section class="px-6 py-12 animate-fadeIn">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Sample Dashboard Card -->
            <div class="bg-white rounded-xl p-6 shadow-lg card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Steps Today</h3>
                        <p class="text-2xl font-bold text-gray-800">8,500</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-walking text-blue-600"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="bg-gray-200 h-2 rounded-full">
                        <div class="bg-primary-color h-2 rounded-full" style="width: 85%"></div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">85% of daily goal</p>
                </div>
            </div>

            <!-- Add more cards as needed -->
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">MyFitness</h3>
                <p class="text-gray-400">Your modern fitness companion for a healthier and happier life.</p>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-white">About Us</a></li>
                    <li><a href="#" class="hover:text-white">Features</a></li>
                    <li><a href="#" class="hover:text-white">Contact</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Follow Us</h3>
                <div class="flex space-x-4">
                    <a href="#" class="hover:text-white"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="hover:text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-white"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="text-center text-gray-400 mt-8">
            <p>© 2024 MyFitness. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const menuBtn = document.querySelector('.menu-btn');
        const navLinks = document.querySelector('.nav-links');

        menuBtn.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    </script>
</body>
</html>