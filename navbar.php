  <!-- Navbar -->
  <header class="fixed w-full z-50 transition-all duration-300 glass-effect">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center bg-cover">
                <a href="../index.php">
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
  <text x="100" y="20" font-family="Arial" font-size="14" fill="#7C3AED">GYANFIT </text>
</svg>
                </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="nav-item text-gray-700 hover:text-indigo-600 transition-colors duration-300">Home</a>
                    <a href="Home/food.php" class="nav-item text-gray-700 hover:text-indigo-600 transition-colors duration-300">Foods</a>
                    <a href="Home/about.php" class="nav-item text-gray-700 hover:text-indigo-600 transition-colors duration-300">About</a>
                    <a href="Home/explore.php" class="nav-item text-gray-700 hover:text-indigo-600 transition-colors duration-300">Explore</a>
                    <div class="flex items-center space-x-4">
                        <a href="login.php"> 
                    <button class="px-6 py-2 rounded-full bg-white text-indigo-600 hover:bg-indigo-50 transition-all duration-300 shadow-md hover:shadow-lg">
                            Login
                        </button>
                        </a>
                        <a href="signup.php"> 
                        <button class="px-6 py-2 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            Sign Up
                        </button>
                        </a>

                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button class="text-gray-700 hover:text-indigo-600 focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </nav>
    </header>
