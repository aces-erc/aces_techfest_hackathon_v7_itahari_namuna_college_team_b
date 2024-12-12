<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife AI - Smart Fitness Tracking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>

<body>

<?php include "navbar.php";?>


<style> 
        :root {
            --primary-color: #4F46E5;
            --secondary-color: #818CF8;
        }
    </style>
    <!-- Hero Section with Wheat Color -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-blue-100"></div>
        <div class="container mx-auto px-6 py-24 relative">
            <div class="max-w-3xl mx-auto text-center animate-fade-in">
                <h1 class="text-5xl font-bold mb-8 text-gray-800 animate__animated animate__fadeInDown">
                    AI-Powered Fitness Tracking
                </h1>
                <p class="text-xl mb-12 text-gray-700 animate__animated animate__fadeInUp">
                    Transform your fitness journey with cutting-edge AI technology, smart tracking, and personalized guidance.
                </p>
                <button class="bg-primary-600 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-primary-700 transition-all duration-300 hover:scale-105 transform animate__animated animate__fadeInUp">
                    Start Your Smart Journey
                </button>
            </div>
        </div>
    </div>

    <!-- AI Features Section -->
    <div class="container mx-auto px-6 -mt-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-8 text-center transform hover:scale-105 transition-all duration-300">
                <div class="text-5xl mb-4">🔍</div>
                <h3 class="text-xl font-bold mb-2">Smart Barcode Scanner</h3>
                <p class="text-gray-600">Instantly track nutrition with our AI-powered barcode scanner</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-8 text-center transform hover:scale-105 transition-all duration-300">
                <div class="text-5xl mb-4">🤖</div>
                <h3 class="text-xl font-bold mb-2">AI Meal Analysis</h3>
                <p class="text-gray-600">Take a photo of your meal for instant nutritional breakdown</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-8 text-center transform hover:scale-105 transition-all duration-300">
                <div class="text-5xl mb-4">📊</div>
                <h3 class="text-xl font-bold mb-2">Smart Progress Tracking</h3>
                <p class="text-gray-600">AI-powered insights and recommendations for your journey</p>
            </div>
        </div>
    </div>



    <!-- AI Features Showcase -->
    <div class="bg-">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mt-12">Smart Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="bg-white/90 backdrop-blur-lg rounded-2xl p-8 shadow-xl">
                    <h3 class="text-2xl font-bold mb-4">Food Recognition AI</h3>
                    <ul class="space-y-4">
                        <li class="flex items-center space-x-3">
                            <span class="text-primary-600">✓</span>
                            <span>Instant food recognition from photos</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <span class="text-primary-600">✓</span>
                            <span>Accurate nutritional breakdown</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <span class="text-primary-600">✓</span>
                            <span>Personalized portion recommendations</span>
                        </li>
                    </ul>
                </div>
                <div class="bg-white/90 backdrop-blur-lg rounded-2xl p-8 shadow-xl">
                    <h3 class="text-2xl font-bold mb-4">Smart Progress Tracking</h3>
                    <ul class="space-y-4">
                        <li class="flex items-center space-x-3">
                            <span class="text-primary-600">✓</span>
                            <span>AI-powered progress analysis</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <span class="text-primary-600">✓</span>
                            <span>Adaptive workout recommendations</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <span class="text-primary-600">✓</span>
                            <span>Real-time performance insights</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section with Primary Color -->
    <div class="bg-primary-600 text-white py-24">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-8 animate__animated animate__fadeInUp">Ready to Transform Your Fitness Journey?</h2>
            <p class="text-xl mb-12 max-w-2xl mx-auto animate__animated animate__fadeInUp">
                Join our AI-powered fitness platform and experience the future of personal training.
            </p>
            <button class="bg-white text-primary-600 px-8 py-4 rounded-full font-bold text-lg hover:bg-primary-50 transition-all duration-300 hover:scale-105 transform animate__animated animate__fadeInUp">
                Start Free Trial
            </button>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 1s ease-out;
        }
        .text-primary-600 { color: #2563eb; }
        .bg-primary-600 { background-color: #2563eb; }
        .hover\:bg-primary-700:hover { background-color: #1d4ed8; }
        .text-primary-800 { color: #1e40af; }
    </style>

    <script>
        // Add scroll animations
        document.addEventListener('DOMContentLoaded', () => {
            const animateOnScroll = () => {
                const elements = document.querySelectorAll('.animate__animated');
                elements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    if (elementTop < window.innerHeight - 100) {
                        element.classList.add('animate__fadeInUp');
                    }
                });
            };
            window.addEventListener('scroll', animateOnScroll);
            animateOnScroll();
        });
    </script>
</body>
</html>