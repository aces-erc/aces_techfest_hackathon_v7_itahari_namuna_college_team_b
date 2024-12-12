<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Barlow', sans-serif;
        }
      
    </style>
</head>

<body class="bg-blue-300 text-white min-h-screen flex items-center justify-center">

<div class="w-full max-w-lg bg-white rounded-lg shadow-2xl p-8 text-blue-900">
    <h1 class="text-3xl font-bold mb-6 text-center">Create Your Account</h1>
    
    <form id="registrationForm" method="POST" action="controller/registercontroller.php">
        <!-- Step 1: Full Name and Phone -->
        <div class="step step-1">
            <h2 class="text-xl font-semibold mb-4 text-center">Let's get started</h2>
            <div class="mb-6">
                <label for="full_name" class="block font-medium mb-2">Full Name</label>
                <input type="text" name="full_name" id="full_name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label for="phone" class="block font-medium mb-2">Phone</label>
                <input type="tel" name="phone" id="phone" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
            </div>
            <div class="mb-6">
                <label for="email" class="block font-medium mb-2">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="nextStep()"
                    class="bg-blue-900 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition">
                    Next
                </button>
            </div>
        </div>

        <!-- Step 2: Passwords -->
        <div class="step step-2 hidden">
            <h2 class="text-xl font-semibold mb-4 text-center">Secure Your Account</h2>
            <div class="mb-6">
                <label for="password" class="block font-medium mb-2">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label for="confirm_password" class="block font-medium mb-2">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
            </div>

            <div class="flex justify-between">
                <button type="button" onclick="prevStep()"
                    class="bg-gray-300 text-blue-900 py-2 px-6 rounded-md hover:bg-gray-400 transition">
                    Back
                </button>
                <button type="button" onclick="nextStep()"
                    class="bg-blue-900 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition">
                    Next
                </button>
            </div>
        </div>

        <!-- Step 3: Age, Weight, Height -->
        <div class="step step-3 hidden">
            <h2 class="text-xl font-semibold mb-4 text-center">Tell us about yourself</h2>
            <div class="mb-6">
                <label for="age" class="block font-medium mb-2">Age</label>
                <input type="number" name="age" id="age" min="1" max="100" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label for="weight" class="block font-medium mb-2">Weight (kg)</label>
                <input type="number" name="weight" id="weight" min="1" step="0.1" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label for="height" class="block font-medium mb-2">Height (cm)</label>
                <input type="number" name="height" id="height" min="1" step="0.1" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
            </div>

            <div class="flex justify-between">
                <button type="button" onclick="prevStep()"
                    class="bg-gray-300 text-blue-900 py-2 px-6 rounded-md hover:bg-gray-400 transition">
                    Back
                </button>
                <button type="button" onclick="nextStep()"
                    class="bg-blue-900 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition">
                    Next
                </button>
            </div>
        </div>

        <!-- Step 4: Weekly Activities -->
        <div class="step step-4 hidden">
            <h2 class="text-xl font-semibold mb-4 text-center">Weekly Activity</h2>
            <div class="mb-6">
                <label for="weekly_activities" class="block font-medium mb-2">Activity Level</label>
                <select name="weekly_activities" id="weekly_activities" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
                    <option value="" disabled selected>Choose an option</option>
                    <option value="highly_active">Highly Active</option>
                    <option value="active">Active</option>
                    <option value="normal">Normal</option>
                </select>
            </div>

            <div class="flex justify-between">
                <button type="button" onclick="prevStep()"
                    class="bg-gray-300 text-blue-900 py-2 px-6 rounded-md hover:bg-gray-400 transition">
                    Back
                </button>
                <button type="submit"
                    class="bg-blue-900 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition">
                    Register
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    let currentStep = 1;
    const steps = document.querySelectorAll('.step');

    function showStep(step) {
        steps.forEach((stepElement, index) => {
            stepElement.classList.toggle('hidden', index + 1 !== step);
        });
    }

    function nextStep() {
        if (currentStep < steps.length) {
            currentStep++;
            showStep(currentStep);
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    }

    // Initialize to show the first step
    showStep(currentStep);
</script>

</body>
</html>







