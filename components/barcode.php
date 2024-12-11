<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Scanner</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-blue-50 min-h-screen flex flex-col">
    <header class="bg-blue-600 text-white p-4 text-center">
        <h1 class="text-2xl font-bold">Barcode Scanner</h1>
    </header>

    <main class="flex-grow flex flex-col items-center justify-center p-4">
        <div id="scanner-container" class="w-full max-w-md aspect-square bg-white rounded-lg shadow-lg flex items-center justify-center mb-4">
            <div id="scanner-placeholder" class="text-blue-600 text-6xl">
                <i class="fas fa-qrcode"></i>
            </div>
        </div>

        <button id="scan-button" class="bg-blue-600 text-white px-6 py-3 rounded-full text-lg font-semibold shadow-lg hover:bg-blue-700 transition duration-300 flex items-center">
            <i class="fas fa-camera mr-2"></i> Scan Barcode
        </button>

        <input type="file" id="file-input" class="hidden" accept="image/*">
        <button id="upload-button" class="mt-4 bg-white text-blue-600 px-6 py-3 rounded-full text-lg font-semibold shadow-lg hover:bg-blue-100 transition duration-300 flex items-center">
            <i class="fas fa-upload mr-2"></i> Upload Image
        </button>
    </main>

    <div id="result-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg max-w-sm w-full">
            <h2 class="text-xl font-bold mb-4" id="result-title">Product Information</h2>
            <p class="mb-2"><strong>Food Name:</strong> <span id="food-name"></span></p>
            <p class="mb-2"><strong>Protein:</strong> <span id="protein"></span> g</p>
            <p class="mb-2"><strong>Calories:</strong> <span id="calorie"></span> kcal</p>
            <button id="add-food-button" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition duration-300">
                Add to My Foods
            </button>
            <button id="close-modal-button" class="mt-4 ml-2 bg-gray-300 text-gray-800 px-4 py-2 rounded-full hover:bg-gray-400 transition duration-300">
                Close
            </button>
        </div>
    </div>

    <script>
        const scannerContainer = document.getElementById('scanner-container');
        const scannerPlaceholder = document.getElementById('scanner-placeholder');
        const scanButton = document.getElementById('scan-button');
        const uploadButton = document.getElementById('upload-button');
        const fileInput = document.getElementById('file-input');
        const resultModal = document.getElementById('result-modal');
        const foodNameElement = document.getElementById('food-name');
        const proteinElement = document.getElementById('protein');
        const calorieElement = document.getElementById('calorie');
        const addFoodButton = document.getElementById('add-food-button');
        const closeModalButton = document.getElementById('close-modal-button');

        let foodData = {};

        function initializeQuagga() {
            Quagga.init({
                inputStream: {
                    type: "LiveStream",
                    constraints: {
                        facingMode: "environment"
                    },
                    area: { top: "10%", right: "10%", left: "10%", bottom: "10%" },
                },
                decoder: {
                    readers: ["ean_reader"]
                }
            }, function(err) {
                if (err) {
                    console.error(err);
                    alert("Error initializing scanner. Please try again.");
                    return;
                }
                scannerPlaceholder.style.display = 'none';
                Quagga.start();
            });

            Quagga.onDetected(function(result) {
                const barcode = result.codeResult.code;
                Quagga.stop();
                fetchProductInfo(barcode);
            });
        }

        async function fetchProductInfo(barcode) {
            try {
                const response = await fetch(`https://world.openfoodfacts.org/api/v0/product/${barcode}.json`);
                const data = await response.json();

                if (data && data.product) {
                    foodData = {
                        food_name: data.product.product_name || "Unknown",
                        protein: data.product.nutriments.proteins || 0,
                        calorie: data.product.nutriments.energy_kcal || 0
                    };

                    foodNameElement.textContent = foodData.food_name;
                    proteinElement.textContent = foodData.protein;
                    calorieElement.textContent = foodData.calorie;
                    resultModal.classList.remove('hidden');
                } else {
                    throw new Error("Product not found");
                }
            } catch (error) {
                console.error(error);
                alert("Unable to fetch product details. Please try again.");
            }
        }

        scanButton.addEventListener('click', () => {
            scannerPlaceholder.style.display = 'block';
            initializeQuagga();
        });

        uploadButton.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    Quagga.decodeSingle({
                        src: e.target.result,
                        numOfWorkers: 0,
                        decoder: {
                            readers: ["ean_reader"]
                        },
                    }, function(result) {
                        if (result && result.codeResult) {
                            fetchProductInfo(result.codeResult.code);
                        } else {
                            alert("Unable to read barcode. Please try again.");
                        }
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        addFoodButton.addEventListener('click', () => {
            // Implement the logic to add food to user's database here
            alert("Food added to your list!");
            resultModal.classList.add('hidden');
        });

        closeModalButton.addEventListener('click', () => {
            resultModal.classList.add('hidden');
        });
    </script>
</body>
</html>