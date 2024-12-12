<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Fitness Institutes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<?php include  'navbar.php'; ?>

<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">About us Page</h1>
        <div class="mb-6">
            <form id="filterForm" class="flex space-x-4">
                <select name="location" id="location" class="p-2 border rounded">
                    <option value="all" selected>All Locations</option>
                    <option value="Itahari">Itahari</option>
                    <option value="Morang">Morang</option>
                    <option value="Biratnagar">Biratnagar</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Filter</button>
            </form>
        </div>
        <div id="institutesContainer" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Cards will be dynamically loaded here -->
        </div>
    </div>

    <script>
        $(document).ready(function () {
            function loadInstitutes(location = 'all') {
                $.ajax({
                    url: '../controller/fetch_explore.php',
                    method: 'GET',
                    data: { location: location },
                    success: function (response) {
                        $('#institutesContainer').html(response);
                    },
                    error: function () {
                        alert('Error fetching data');
                    }
                });
            }

            // Load all institutes initially
            loadInstitutes();

            // Handle form submission for filtering
            $('#filterForm').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission
                const selectedLocation = $('#location').val();
                loadInstitutes(selectedLocation);
            });
        });
    </script>
</body>
</html>
