<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife - Transform Your Body</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-50">
    <?php include "navbar.php"; ?>
 

    <!-- Hero Section -->
    <div class="bg-blue-600 text-white">
        <div class="container mx-auto px-6 py-24">
            <div class="max-w-3xl mx-auto text-center" data-aos="fade-up">
                <h1 class="text-5xl font-bold mb-8">Transform Your Body, Transform Your Life</h1>
                <p class="text-xl mb-12">Join our premium fitness center and experience world-class training with expert coaches.</p>
                <button class="bg-white text-blue-600 px-8 py-4 rounded-full font-bold text-lg hover:bg-blue-50 transition-transform hover:scale-105 transform">
                    Start Your Journey
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="container mx-auto px-6 -mt-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="text-4xl font-bold text-blue-600 mb-2">1000+</div>
                <div class="text-gray-600">Active Members</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="text-4xl font-bold text-blue-600 mb-2">50+</div>
                <div class="text-gray-600">Expert Trainers</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center" data-aos="fade-up" data-aos-delay="300">
                <div class="text-4xl font-bold text-blue-600 mb-2">100+</div>
                <div class="text-gray-600">Weekly Classes</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center" data-aos="fade-up" data-aos-delay="400">
                <div class="text-4xl font-bold text-blue-600 mb-2">95%</div>
                <div class="text-gray-600">Success Rate</div>
            </div>
        </div>
    </div>

    <!-- Programs Section -->
    <div class="container mx-auto px-6 py-24">
        <h2 class="text-3xl font-bold text-center mb-16">Our Programs</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-xl transition-shadow" data-aos="fade-up">
                <img src="/api/placeholder/400/300" alt="Strength Training" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">Strength Training</h3>
                    <p class="text-gray-600 mb-4">Build muscle, increase strength, and improve your overall fitness with our comprehensive strength training program.</p>
                    <a href="#" class="text-blue-600 font-semibold group-hover:text-blue-800">Learn More →</a>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-xl transition-shadow" data-aos="fade-up" data-aos-delay="100">
                <img src="/api/placeholder/400/300" alt="Cardio Fitness" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">Cardio Fitness</h3>
                    <p class="text-gray-600 mb-4">Enhance your endurance and burn calories with our high-energy cardio workouts designed for all fitness levels.</p>
                    <a href="#" class="text-blue-600 font-semibold group-hover:text-blue-800">Learn More →</a>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-xl transition-shadow" data-aos="fade-up" data-aos-delay="200">
                <img src="/api/placeholder/400/300" alt="Yoga & Flexibility" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">Yoga & Flexibility</h3>
                    <p class="text-gray-600 mb-4">Improve flexibility, reduce stress, and find inner peace with our expert-led yoga and stretching sessions.</p>
                    <a href="#" class="text-blue-600 font-semibold group-hover:text-blue-800">Learn More →</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Trainers Section -->
    <div class="bg-gray-50 py-24">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-16">Expert Trainers</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center" data-aos="fade-up">
                    <div class="w-32 h-32 mx-auto rounded-full overflow-hidden mb-4 ring-4 ring-blue-600/20">
                        <img src="/api/placeholder/200/200" alt="Trainer" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold">John Smith</h3>
                    <p class="text-gray-600">CrossFit Expert</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-32 h-32 mx-auto rounded-full overflow-hidden mb-4 ring-4 ring-blue-600/20">
                        <img src="/api/placeholder/200/200" alt="Trainer" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold">Sarah Johnson</h3>
                    <p class="text-gray-600">Yoga Instructor</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-32 h-32 mx-auto rounded-full overflow-hidden mb-4 ring-4 ring-blue-600/20">
                        <img src="/api/placeholder/200/200" alt="Trainer" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold">Mike Wilson</h3>
                    <p class="text-gray-600">Strength Coach</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-blue-600 text-white py-24">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-8">Ready to Start Your Fitness Journey?</h2>
            <p class="text-xl mb-12 max-w-2xl mx-auto">Join our community today and transform your life with expert guidance and support.</p>
            <button class="bg-white text-blue-600 px-8 py-4 rounded-full font-bold text-lg hover:bg-blue-50 transition-transform hover:scale-105 transform">
                Get Started Now
            </button>
        </div>
    </div>

   

    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>
</html>