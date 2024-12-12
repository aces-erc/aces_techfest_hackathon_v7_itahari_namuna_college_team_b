<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Calendar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 50;
        }
        .modal.active {
            display: flex;
        }
        .day-completed {
            pointer-events: none;
        }
        .tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
        .tooltip-text {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: #fff;
            padding: 5px;
            border-radius: 4px;
            white-space: nowrap;
            font-size: 12px;
            z-index: 10;
            transition: opacity 0.3s ease;
        }
        .fixed-header {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            background-color: white;
            z-index: 40;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <?php include_once '../includes/sidebar.php'; ?>

    <div class="ml-[250px] p-6 min-h-screen relative">
        <div class="fixed-header flex justify-between items-center">
            <h1 class="text-2xl font-bold text-indigo-600">Workout Calendar</h1>
            <a href="report.php" class="p-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition-colors duration-300">
                <i class="fas fa-chart-bar"></i>
            </a>
        </div>

        <div class="max-w-7xl mx-auto mt-20">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <!-- Calendar Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-3xl font-bold text-indigo-600" id="current-month-en">December 2024</h2>
                        <h3 class="text-2xl font-bold text-indigo-500" id="current-month-np">पौष २०८०</h3>
                    </div>
                    <div class="flex space-x-4">
                        <button id="prev-month" class="p-2 hover:bg-indigo-100 rounded-lg transition-all duration-300">
                            <i class="fas fa-chevron-left text-indigo-600"></i>
                        </button>
                        <button id="next-month" class="p-2 hover:bg-indigo-100 rounded-lg transition-all duration-300">
                            <i class="fas fa-chevron-right text-indigo-600"></i>
                        </button>
                    </div>
                </div>

                <!-- Language Toggle -->
                <div class="flex justify-end space-x-4 mb-4">
                    <button id="lang-en" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all duration-300">
                        English
                    </button>
                    <button id="lang-np" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-300">
                        नेपाली
                    </button>
                </div>

                <!-- Weekday Headers -->
                <div class="grid grid-cols-7 gap-4 text-center">
                    <div class="space-y-1">
                        <div class="font-semibold text-gray-600">Sun</div>
                        <div class="text-sm text-gray-500">आइत</div>
                    </div>
                    <div class="space-y-1">
                        <div class="font-semibold text-gray-600">Mon</div>
                        <div class="text-sm text-gray-500">सोम</div>
                    </div>
                    <div class="space-y-1">
                        <div class="font-semibold text-gray-600">Tue</div>
                        <div class="text-sm text-gray-500">मंगल</div>
                    </div>
                    <div class="space-y-1">
                        <div class="font-semibold text-gray-600">Wed</div>
                        <div class="text-sm text-gray-500">बुध</div>
                    </div>
                    <div class="space-y-1">
                        <div class="font-semibold text-gray-600">Thu</div>
                        <div class="text-sm text-gray-500">बिही</div>
                    </div>
                    <div class="space-y-1">
                        <div class="font-semibold text-gray-600">Fri</div>
                        <div class="text-sm text-gray-500">शुक्र</div>
                    </div>
                    <div class="space-y-1">
                        <div class="font-semibold text-gray-600">Sat</div>
                        <div class="text-sm text-gray-500">शनि</div>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div id="calendar" class="grid grid-cols-7 gap-4 mt-4">
                    <!-- Days will be dynamically added here -->
                </div>

                <!-- Workout Legend -->
                <div class="mt-6 flex flex-wrap gap-4 text-sm text-gray-600">
                    <div class="flex items-center">
                        <i class="fas fa-running text-green-500 mr-2"></i>
                        <span class="mr-1">Running</span>
                        <span class="text-gray-500">दौड</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-dumbbell text-purple-500 mr-2"></i>
                        <span class="mr-1">Strength</span>
                        <span class="text-gray-500">शक्ति</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-bicycle text-blue-500 mr-2"></i>
                        <span class="mr-1">Cycling</span>
                        <span class="text-gray-500">साइकलिङ</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-swimming-pool text-cyan-500 mr-2"></i>
                        <span class="mr-1">Swimming</span>
                        <span class="text-gray-500">पौडी</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-heartbeat text-red-500 mr-2"></i>
                        <span class="mr-1">Cardio</span>
                        <span class="text-gray-500">कार्डियो</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="workout-modal" class="modal">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <h2 class="text-xl font-semibold mb-4">Did you workout today?</h2>
            <div class="flex justify-center space-x-4">
                <button id="yes-btn" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Yes</button>
                <button id="no-btn" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">No</button>
            </div>
        </div>
    </div>

    <script>
        const calendar = document.getElementById('calendar');
        const modal = document.getElementById('workout-modal');
        const yesBtn = document.getElementById('yes-btn');
        const noBtn = document.getElementById('no-btn');
        const prevMonthBtn = document.getElementById('prev-month');
        const nextMonthBtn = document.getElementById('next-month');
        const currentMonthEn = document.getElementById('current-month-en');
        const currentMonthNp = document.getElementById('current-month-np');
        const langEn = document.getElementById('lang-en');
        const langNp = document.getElementById('lang-np');

        let selectedDay = null;
        let currentDate = new Date();
        let currentLanguage = 'en';

        const nepaliMonths = ['बैशाख', 'जेठ', 'असार', 'श्रावण', 'भदौ', 'असोज', 'कार्तिक', 'मंसिर', 'पुष', 'माघ', 'फाल्गुन', 'चैत्र'];
        const englishMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        function updateCalendarHeader() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            currentMonthEn.textContent = `${englishMonths[month]} ${year}`;
            // This is a placeholder. You'd need to implement proper Nepali date conversion
            currentMonthNp.textContent = `${nepaliMonths[month]} ${year + 57}`; 
        }

        async function fetchCalendar() {
            try {
                const response = await fetch('../controller/workout_trace.php');
                const data = await response.json();

                calendar.innerHTML = ''; // Clear existing calendar

                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();
                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                // Add empty cells for days before the 1st of the month
                for (let i = 0; i < firstDay; i++) {
                    const emptyDay = document.createElement('div');
                    emptyDay.className = 'p-4 rounded-lg';
                    calendar.appendChild(emptyDay);
                }

                for (let i = 1; i <= daysInMonth; i++) {
                    const date = new Date(year, month, i);
                    const dayString = date.toISOString().split('T')[0];
                    const status = data.find(d => d.day === dayString)?.status || 'neutral';

                    const dayDiv = document.createElement('div');
                    dayDiv.className = `relative p-4 rounded-lg hover:bg-indigo-50 transition-all duration-300 cursor-pointer ${getStatusClass(status)} ${status !== 'neutral' ? 'day-completed' : ''}`;
                    dayDiv.innerHTML = `
                        <div>${i}</div>
                        <div class="text-sm">${convertToNepaliNumeral(i)}</div>
                    `;
                    dayDiv.dataset.date = dayString;

                    if (status === 'neutral') {
                        dayDiv.onclick = () => openModal(dayString);
                    } else {
                        dayDiv.title = `You have already marked this day as ${status}.`;
                        // Add workout icon based on status
                        const icon = document.createElement('div');
                        icon.className = 'absolute bottom-1 right-1';
                        icon.innerHTML = getWorkoutIcon(status);
                        dayDiv.appendChild(icon);
                    }

                    calendar.appendChild(dayDiv);
                }

                updateCalendarHeader();
            } catch (error) {
                console.error('Error fetching calendar:', error);
            }
        }

        function openModal(day) {
            selectedDay = day;
            modal.classList.add('active');
        }

        function closeModal() {
            modal.classList.remove('active');
        }

        async function updateStatus(day, status) {
            try {
                const response = await fetch('../controller/workout_update.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ day, status })
                });

                if (response.ok) {
                    closeModal();
                    fetchCalendar(); // Refresh the calendar
                } else {
                    console.error('Error updating status:', response.statusText);
                }
            } catch (error) {
                console.error('Error updating status:', error);
            }
        }

        function getStatusClass(status) {
            switch (status) {
                case 'workout': return 'bg-green-200 text-green-800';
                case 'notworkout': return 'bg-red-200 text-red-800';
                default: return 'bg-white text-gray-800';
            }
        }

        function getWorkoutIcon(status) {
            // This is a placeholder. You should implement logic to determine the correct icon based on the workout type
            return '<i class="fas fa-running text-green-500 text-sm"></i>';
        }

        function convertToNepaliNumeral(number) {
            const nepaliNumerals = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
            return number.toString().split('').map(digit => nepaliNumerals[parseInt(digit)]).join('');
        }

        yesBtn.onclick = () => updateStatus(selectedDay, 'workout');
        noBtn.onclick = () => updateStatus(selectedDay, 'notworkout');

        prevMonthBtn.onclick = () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            fetchCalendar();
        };

        nextMonthBtn.onclick = () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            fetchCalendar();
        };

        langEn.onclick = () => {
            currentLanguage = 'en';
            langEn.classList.replace('bg-gray-200', 'bg-indigo-600');
            langEn.classList.replace('text-gray-700', 'text-white');
            langNp.classList.replace('bg-indigo-600', 'bg-gray-200');
            langNp.classList.replace('text-white', 'text-gray-700');
            fetchCalendar();
        };

        langNp.onclick = () => {
            currentLanguage = 'np';
            langNp.classList.replace('bg-gray-200', 'bg-indigo-600');
            langNp.classList.replace('text-gray-700', 'text-white');
            langEn.classList.replace('bg-indigo-600', 'bg-gray-200');
            langEn.classList.replace('text-white', 'text-gray-700');
            fetchCalendar();
        };

        // Initial fetch
        fetchCalendar();
    </script>
</body>
</html>