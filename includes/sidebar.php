<nav class="bg-white shadow-xl h-screen fixed top-0 left-0 min-w-[250px] py-6 font-[sans-serif] overflow-auto">
    <div class="relative flex flex-col h-full">
        <!-- Logo -->
        <a href="dashboard.php" class="text-center mb-8 item-center pl-12 ">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 100" class="32 h-16" style="min-width: 120px;">

<circle cx="40" cy="50" r="8" fill="#4F46E5">
  <animate attributeName="opacity" values="1;0.5;1" dur="2s" repeatCount="indefinite" />
</circle>
<circle cx="80" cy="30" r="8" fill="#4F46E5">
  <animate attributeName="opacity" values="0.5;1;0.5" dur="2s" repeatCount="indefinite" />
</circle>
<circle cx="80" cy="70" r="8" fill="#4F46E5">
  <animate attributeName="opacity" values="0.5;1;0.5" dur="2s" repeatCount="indefinite" />
</circle>
<circle cx="120" cy="50" r="8" fill="#4F46E5">
  <animate attributeName="opacity" values="1;0.5;1" dur="2s" repeatCount="indefinite" />
</circle>

<line x1="48" y1="50" x2="72" y2="30" stroke="#4F46E5" stroke-width="2">
  <animate attributeName="opacity" values="0.3;0.8;0.3" dur="2s" repeatCount="indefinite" />
</line>
<line x1="48" y1="50" x2="72" y2="70" stroke="#4F46E5" stroke-width="2">
  <animate attributeName="opacity" values="0.3;0.8;0.3" dur="2s" repeatCount="indefinite" />
</line>
<line x1="88" y1="30" x2="112" y2="50" stroke="#4F46E5" stroke-width="2">
  <animate attributeName="opacity" values="0.3;0.8;0.3" dur="2s" repeatCount="indefinite" />
</line>
<line x1="88" y1="70" x2="112" y2="50" stroke="#4F46E5" stroke-width="2">
  <animate attributeName="opacity" values="0.3;0.8;0.3" dur="2s" repeatCount="indefinite" />
</line>

<rect x="140" y="45" width="20" height="10" rx="2" fill="#7C3AED">
  <animate attributeName="transform" attributeType="XML" type="rotate" 
    from="0 150 50" to="360 150 50" dur="4s" repeatCount="indefinite" />
</rect>
<circle cx="135" cy="50" r="6" fill="#7C3AED">
  <animate attributeName="transform" attributeType="XML" type="rotate" 
    from="0 150 50" to="360 150 50" dur="4s" repeatCount="indefinite" />
</circle>
<circle cx="165" cy="50" r="6" fill="#7C3AED">
  <animate attributeName="transform" attributeType="XML" type="rotate" 
    from="0 150 50" to="360 150 50" dur="4s" repeatCount="indefinite" />
</circle>

<text x="10" y="70" font-family="Arial" font-size="18" fill="#4F46E5">AI</text>
<text x="100" y="20" font-family="Arial" font-size="14" fill="#7C3AED">GYANFIT</text>
</svg>
        </a>

        <!-- Navigation Links -->
        <ul class="space-y-3 flex-1">
            <li>
                <a href="dashboard.php"
                    class="text-sm flex items-center text-[#007bff] border-r-[5px] border-[#077bff] bg-gray-100 px-8 py-4 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-[18px] h-[18px] mr-4"
                        viewBox="0 0 512 512">
                        <path
                            d="M197.332 170.668h-160C16.746 170.668 0 153.922 0 133.332v-96C0 16.746 16.746 0 37.332 0h160c20.59 0 37.336 16.746 37.336 37.332v96c0 20.59-16.746 37.336-37.336 37.336zM37.332 32A5.336 5.336 0 0 0 32 37.332v96a5.337 5.337 0 0 0 5.332 5.336h160a5.338 5.338 0 0 0 5.336-5.336v-96A5.337 5.337 0 0 0 197.332 32zm160 480h-160C16.746 512 0 495.254 0 474.668v-224c0-20.59 16.746-37.336 37.332-37.336h160c20.59 0 37.336 16.746 37.336 37.336v224c0 20.586-16.746 37.332-37.336 37.332zm-160-266.668A5.337 5.337 0 0 0 32 250.668v224A5.336 5.336 0 0 0 37.332 480h160a5.337 5.337 0 0 0 5.336-5.332v-224a5.338 5.338 0 0 0-5.336-5.336z"
                            data-original="#000000" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="workout.php"
                    class="text-black text-sm flex items-center hover:text-[#007bff] hover:border-r-[5px] border-[#077bff] hover:bg-gray-100 px-8 py-4 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-[18px] h-[18px] mr-4"
                        viewBox="0 0 24 24">
                        <path d="M21 9h-3V7c0-1.105-.896-2-2-2H8c-1.104 0-2 .895-2 2v2H3c-1.105 0-2 .895-2 2v2c0 1.105.895 2 2 2h3v2c0 1.104.896 2 2 2h8c1.104 0 2-.896 2-2v-2h3c1.104 0 2-.896 2-2v-2c0-1.105-.896-2-2-2zm-4 7H8v-8h9v8zm-11-5H3v-2h3v2z" />
                    </svg>
                    <span>Workouts</span>
                </a>
            </li>
            <li>
                <a href="suggestion.php"
                    class="text-black text-sm flex items-center hover:text-[#007bff] hover:border-r-[5px] border-[#077bff] hover:bg-gray-100 px-8 py-4 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-[18px] h-[18px] mr-4"
                        viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-4.42 0-8 1.79-8 4v2h16v-2c0-2.21-3.58-4-8-4z" />
                    </svg>
                    <span>Suggestion</span>
                </a>
            </li>
            <li>
                <a href="food.php"
                    class="text-black text-sm flex items-center hover:text-[#007bff] hover:border-r-[5px] border-[#077bff] hover:bg-gray-100 px-8 py-4 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-[18px] h-[18px] mr-4"
                        viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12c0 3.87 2.19 7.24 5.42 8.88L8 16h8v-4H8v-2h6c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2h-2v2h2v2H8v2h8v2H8v2H6v2.11C3.89 17.68 2 14.97 2 12c0-5.52 4.48-10 10-10s10 4.48 10 10c0 2.97-1.89 5.68-4.53 7.12L18 16h-2v4l1.11.38C19.81 19.24 22 15.87 22 12c0-5.52-4.48-10-10-10z" />
                    </svg>
                    <span>Food Log</span>
                </a>
            </li>
            <li>
                <a href="profile.php"
                    class="text-black text-sm flex items-center hover:text-[#007bff] hover:border-r-[5px] border-[#077bff] hover:bg-gray-100 px-8 py-4 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-[18px] h-[18px] mr-4"
                        viewBox="0 0 24 24">
                        <path d="M12 0C8.13 0 4.84 2.69 4.17 6.37L1.79 6.8a1 1 0 00-.79 1.03c0 .46.31.85.75.96l2.42.48c-.1.65-.16 1.32-.16 2 0 .68.06 1.35.16 2l-2.42.48a1 1 0 00-.75.96c0 .47.31.85.79 1.03l2.37.49c.68 3.68 3.97 6.37 7.83 6.37s7.15-2.69 7.83-6.37l2.37-.49a1 1 0 00.79-1.03c0-.47-.31-.85-.75-.96l-2.42-.48c.1-.65.16-1.32.16-2 0-.68-.06-1.35-.16-2l2.42-.48a1 1 0 00.75-.96c0-.47-.31-.85-.79-1.03L19.83 6.8C19.16 2.69 15.87 0 12 0zm0 2c3.45 0 6.24 2.56 6.72 6H5.28C5.76 4.56 8.55 2 12 2zm-7.53 9H19.5c.08.32.13.65.17 1H4.3c.04-.35.09-.68.17-1zm7.53 7c-3.45 0-6.24-2.56-6.72-6h13.45c-.48 3.44-3.27 6-6.73 6z" />
                    </svg>
                    <span>Profile</span>
                </a>
            </li>
            <li>
                <a href="settings.php"
                    class="text-black text-sm flex items-center hover:text-[#007bff] hover:border-r-[5px] border-[#077bff] hover:bg-gray-100 px-8 py-4 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-[18px] h-[18px] mr-4"
                        viewBox="0 0 24 24">
                        <path d="M12 0C8.13 0 4.84 2.69 4.17 6.37L1.79 6.8a1 1 0 00-.79 1.03c0 .46.31.85.75.96l2.42.48c-.1.65-.16 1.32-.16 2 0 .68.06 1.35.16 2l-2.42.48a1 1 0 00-.75.96c0 .47.31.85.79 1.03l2.37.49c.68 3.68 3.97 6.37 7.83 6.37s7.15-2.69 7.83-6.37l2.37-.49a1 1 0 00.79-1.03c0-.47-.31-.85-.75-.96l-2.42-.48c.1-.65.16-1.32.16-2 0-.68-.06-1.35-.16-2l2.42-.48a1 1 0 00.75-.96c0-.47-.31-.85-.79-1.03L19.83 6.8C19.16 2.69 15.87 0 12 0zm0 2c3.45 0 6.24 2.56 6.72 6H5.28C5.76 4.56 8.55 2 12 2zm-7.53 9H19.5c.08.32.13.65.17 1H4.3c.04-.35.09-.68.17-1zm7.53 7c-3.45 0-6.24-2.56-6.72-6h13.45c-.48 3.44-3.27 6-6.73 6z" />
                    </svg>
                    <span>Settings</span>
                </a>
            </li>
            <li>
                <a href="../includes/logout.php"
                    class="text-black text-sm flex items-center hover:text-[#007bff] hover:border-r-[5px] border-[#077bff] hover:bg-gray-100 px-8 py-4 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-[18px] h-[18px] mr-4"
                        viewBox="0 0 24 24">
                        <path d="M10 2v2H5v16h5v2H3V2h7zm6.707 13.293l-1.414 1.414L16.586 18H10v-2h6.586l-1.293-1.293 1.414-1.414L21 16l-4.293 4.293z" />
                    </svg>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
