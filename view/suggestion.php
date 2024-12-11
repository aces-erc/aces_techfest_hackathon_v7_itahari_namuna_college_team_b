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
        .message {
            transition: all 0.3s ease;
        }
        .message:hover {
            transform: translateY(-2px);
        }
        .message.user {
            background-color: #bfdbfe;
            border-radius: 20px 20px 0 20px;
        }
        .message.bot {
            background-color: #e5e7eb;
            border-radius: 20px 20px 20px 0;
        }
        .typing-indicator {
            animation: pulse 1s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-100 to-purple-100 min-h-screen text-gray-800">
    <?php include_once '../includes/sidebar.php'; ?>
    <div class="ml-64 p-8 flex flex-col items-center justify-center min-h-screen">
        <h1 class="text-2xl font-bold mb-8 text-blue-800">Ask AI Suggestions</h1>
        <div class="bg-white w-full max-w-4xl rounded-lg shadow-lg overflow-hidden">
            <div class="bg-blue-600 text-white p-4 flex justify-between items-center">
                <h2 class="text-xl">AI Nutrition Chat</h2>
                <div class="flex items-center">
                    <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                    <span>Online</span>
                </div>
            </div>
            <div id="message-container" class="h-96 p-4 overflow-y-auto space-y-4"></div>
            <div class="bg-gray-100 p-4">
                <p id="typing-indicator" class="text-gray-500 text-sm hidden">AI is typing...</p>
                <div class="flex items-center space-x-4">
                    <input id="user-input" type="text" placeholder="Ask about your diet..." class="w-full p-2 border rounded">
                    <button onclick="sendMessage()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Send</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const messageContainer = document.getElementById('message-container');
        const typingIndicator = document.getElementById('typing-indicator');
        const userInput = document.getElementById('user-input');

        userInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        async function sendMessage() {
            const userInputValue = userInput.value.trim();
            if (!userInputValue) return;

            addMessage(userInputValue, 'user');
            userInput.value = '';

            typingIndicator.classList.remove('hidden');

            try {
                const response = await fetch('../controller/fetch_ai.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ prompt: userInputValue })
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
                addMessage('Error connecting to AI. Please try again.', 'bot');
            }
        }

        function addMessage(content, type) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${type} p-4 max-w-[75%]`;
            messageDiv.textContent = content;
            messageContainer.appendChild(messageDiv);
            messageContainer.scrollTop = messageContainer.scrollHeight;
            return messageDiv;
        }

        async function displayTypingEffect(element, text) {
            const delay = 20;
            for (let i = element.textContent.length; i < text.length; i++) {
                element.textContent += text[i];
                await new Promise((resolve) => setTimeout(resolve, delay));
            }
        }
    </script>
</body>
</html>
