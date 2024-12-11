<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Nutritionist Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .chat-container {
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }
        .message {
            transition: all 0.3s ease;
        }
        .message:hover {
            transform: translateY(-2px);
        }
        .message.user {
            background-color: #bfdbfe;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            border-bottom-left-radius: 20px;
        }
        .message.bot {
            background-color: #e5e7eb;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .typing-indicator {
            animation: pulse 1s infinite;
        }
        .input-container input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-100 to-purple-100 min-h-screen text-gray-800">
    <?php include_once '../includes/sidebar.php'; ?>
    <div class="ml-64 p-8 flex flex-col items-center justify-center min-h-screen">
        <h1 class="text-2xl font-bold mb-8 text-blue-800 fade-in">Gyan AI Chat</h1>
        <div class="chat-container w-full max-w-4xl rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-blue-600 text-white p-6 flex items-center justify-between">
                <h2 class="text-2xl font-semibold">Chat for sugesstion </h2>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                    <span class="text-sm">Online</span>
                </div>
            </div>
            
            <div id="message-container" class="h-96 overflow-y-auto p-6 space-y-4">
                <!-- Messages will be dynamically added here -->
            </div>
            
            <div class="bg-gray-100 p-6">
                <p id="typing-indicator" class="typing-indicator text-gray-500 text-sm mb-2 hidden">AI is thinking...</p>
                <div class="flex items-center space-x-4">
                    <input id="user-input" type="text" placeholder="Ask about your diet..." class="flex-1 p-4 rounded-full border-2 border-blue-300 focus:outline-none focus:border-blue-500 transition-all duration-300" />
                    <button onclick="sendMessage()" class="bg-blue-600 text-white px-6 py-4 rounded-lg hover:bg-blue-700 transition-all duration-300 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    const messageContainer = document.getElementById('message-container');
    const typingIndicator = document.getElementById('typing-indicator');
    const userInput = document.getElementById('user-input');

    userInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    async function sendMessage() {
        const userInputValue = userInput.value;

        if (!userInputValue.trim()) return;

        addMessage(userInputValue, 'user');
        userInput.value = '';

        typingIndicator.classList.remove('hidden');

        try {
            const response = await fetch('../controller/fetch_ai.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ prompt: userInputValue }),
            });

            const reader = response.body.getReader();
            const decoder = new TextDecoder();
            let botMessage = '';
            let messageElement = addMessage('', 'bot');

            while (true) {
                const { done, value } = await reader.read();
                if (done) break;

                botMessage += decoder.decode(value);
                await displayTypingEffect(messageElement, botMessage);
            }

            typingIndicator.classList.add('hidden');
        } catch (error) {
            typingIndicator.classList.add('hidden');
            addMessage('Error fetching recommendation. Please try again.', 'bot');
        }
    }

    function addMessage(content, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type} p-4 rounded-lg shadow-md max-w-[80%] ${type === 'user' ? 'ml-auto bg-blue-100' : 'mr-auto bg-white'} fade-in`;
        
        const avatar = document.createElement('div');
        avatar.className = `w-8 h-8 rounded-full ${type === 'user' ? 'bg-blue-500' : 'bg-gray-500'} text-white flex items-center justify-center text-sm font-bold mb-2`;
        avatar.textContent = type === 'user' ? 'You' : 'AI';

        const textContent = document.createElement('p');
        textContent.textContent = content;

        messageDiv.appendChild(avatar);
        messageDiv.appendChild(textContent);
        
        messageContainer.appendChild(messageDiv);
        messageContainer.scrollTop = messageContainer.scrollHeight;
        return textContent;
    }

    async function displayTypingEffect(element, text) {
        const delay = 20;
        for (let i = element.textContent.length; i < text.length; i++) {
            element.textContent += text[i];
            messageContainer.scrollTop = messageContainer.scrollHeight;
            await new Promise(resolve => setTimeout(resolve, delay));
        }
    }
    </script>
</body>
</html>