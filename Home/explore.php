<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Fitness Institutes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        .filter-dropdown {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    </style>
</head>
<?php include 'navbar.php'; ?>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8  py-12">
        <!-- Hero Section -->
        <div class="text-center mb-3 space-y-4 fade-in mt-20">
            <h1 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                Explore Fitness Institutes
            </h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Discover the perfect fitness institute that matches your goals and location
            </p>
        </div>

        <!-- Filter Section -->
        <div class="mb-12 fade-in" style="animation-delay: 0.2s;">
            <div class="max-w-xl mx-auto">
                <form id="filterForm" class="bg-white p-6 rounded-2xl shadow-lg flex flex-col sm:flex-row gap-4 items-center">
                    <div class="relative flex-1">
                        <select name="location" id="location" class="filter-dropdown w-full appearance-none bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500 transition duration-300">
                            <option value="all" selected>All Locations</option>
                            <option value="Itahari">Itahari</option>
                            <option value="Morang">Morang</option>
                            <option value="Biratnagar">Biratnagar</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-xl transition duration-300 transform hover:-translate-y-0.5 hover:shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-filter"></i>
                        <span>Apply Filter</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Grid Container -->
        <div id="institutesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Cards will be dynamically loaded here -->
            <!-- Loading Placeholder -->
            <div class="loading-placeholder text-center col-span-full py-12 text-gray-500">
                <i class="fas fa-spinner fa-spin fa-2x mb-4"></i>
                <p>Loading institutes...</p>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            function loadInstitutes(location = 'all') {
                $('#institutesContainer').html('<div class="loading-placeholder text-center col-span-full py-12 text-gray-500"><i class="fas fa-spinner fa-spin fa-2x mb-4"></i><p>Loading institutes...</p></div>');
                
                $.ajax({
                    url: '../controller/fetch_explore.php',
                    method: 'GET',
                    data: { location: location },
                    success: function (response) {
                        $('#institutesContainer').fadeOut(200, function() {
                            $(this).html(response).fadeIn(400);
                            
                            // Add animation classes to new cards
                            $('.institute-card').each(function(index) {
                                $(this).addClass('fade-in').css('animation-delay', (index * 0.1) + 's');
                            });
                        });
                    },
                    error: function () {
                        $('#institutesContainer').html('<div class="text-center col-span-full py-12 text-red-500"><i class="fas fa-exclamation-circle fa-2x mb-4"></i><p>Error loading institutes. Please try again.</p></div>');
                    }
                });
            }

            // Load all institutes initially
            loadInstitutes();

            // Handle form submission for filtering
            $('#filterForm').on('submit', function (e) {
                e.preventDefault();
                const selectedLocation = $('#location').val();
                loadInstitutes(selectedLocation);
                
                // Animate the filter button
                $(this).find('button').addClass('scale-95').delay(200).queue(function(next) {
                    $(this).removeClass('scale-95');
                    next();
                });
            });

            // Smooth hover effects for select
            $('#location').hover(
                function() { $(this).addClass('bg-gray-100'); },
                function() { $(this).removeClass('bg-gray-100'); }
            );
        });
    </script>
</body>
</html>