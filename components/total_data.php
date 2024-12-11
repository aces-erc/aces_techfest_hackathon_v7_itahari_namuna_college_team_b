        <!-- Total Summary -->
        <div class="bg-white p-6 rounded-lg shadow mb-6 max-w-4xl">
            <h2 class="text-xl font-bold mb-4">Nutritional Summary</h2>
            <div class="grid grid-cols-3 gap-6">
                <div class="text-center">
                    <p class="text-sm text-gray-500">Total Protein</p>
                    <p class="text-lg font-bold text-gray-800"><?php echo $totalProtein ?? 0; ?>g</p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-500">Total Calories</p>
                    <p class="text-lg font-bold text-gray-800"><?php echo $totalCalories ?? 0; ?> kcal</p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-500">Total Carbs</p>
                    <p class="text-lg font-bold text-gray-800"><?php echo $totalCarbs ?? 0; ?>g</p>
                </div>
            </div>
        </div>