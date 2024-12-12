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
            opacity: 0;
            transform: translateY(20px);
        }
        .message.show {
            opacity: 1;
            transform: translateY(0);
        }
        .message.user {
            background-color: #1E40AF;
            color: white;
            border-radius: 20px 20px 0 20px;
        }
        .message.bot {
            background-color: white;
            color: #1E40AF;
            border-radius: 20px 20px 20px 0;
            border: 1px solid #1E40AF;
        }
        .typing-indicator {
            display: inline-block;
        }
        .typing-indicator span {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #1E40AF;
            border-radius: 50%;
            margin: 0 2px;
            opacity: 0.4;
            animation: typing 1s infinite;
        }
        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }
        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }
        @keyframes typing {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 1; }
        }
        .default-prompt {
            background-color: #F3F4F6;
            color: #1E40AF;
            border: 1px solid #1E40AF;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }
        .default-prompt:hover {
            background-color: #1E40AF;
            color: white;
        }
    </style>
</head>
<body class="bg-[#1E40AF] text-white min-h-screen">
    <?php include_once '../includes/sidebar.php'; ?>
    <div class="ml-64 p-8 flex flex-col items-center justify-center min-h-screen">
        <h1 class="text-3xl font-bold mb-8 text-white">AI Nutrition Suggestions</h1>
        <div class="bg-white w-full max-w-4xl rounded-lg shadow-2xl overflow-hidden">
            <div class="bg-[#1E40AF] text-white p-6 flex justify-between items-center">
                <h2 class="text-2xl font-semibold">AI Nutrition Chat</h2>
                <div class="flex items-center">
                    <span class="w-3 h-3 bg-green-400 rounded-full mr-2"></span>
                    <span class="text-sm">Online</span>
                </div>
            </div>
            <div class="p-4 flex flex-wrap gap-4">
                <!-- Default prompts -->
                <span class="default-prompt" onclick="selectPrompt('What\'s my body condition?')">What's my body condition?</span>
                <span class="default-prompt" onclick="selectPrompt('How to drink water?')">How to drink water?</span>
                <span class="default-prompt" onclick="selectPrompt('What\'s a balanced diet?')">What's a balanced diet?</span>
                <span class="default-prompt" onclick="selectPrompt('How can I increase protein intake?')">How can I increase protein intake?</span>
            </div>
            <div id="message-container" class="h-[calc(100vh-300px)] p-6 overflow-y-auto space-y-6"></div>
            <div class="bg-gray-100 p-6">
                <div id="typing-indicator" class="text-[#1E40AF] text-sm mb-2 hidden">
                    <div class="typing-indicator">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    AI is thinking...
                </div>
                <div class="flex items-center space-x-4">
                    <input style="color:black" id="user-input" type="text" placeholder="Ask about your diet..." class="w-full p-3 border border-[#1E40AF] rounded-full focus:outline-none focus:ring-2 focus:ring-[#1E40AF] transition-all duration-300">
                    <button onclick="sendMessage()" class="bg-[#1E40AF] text-white px-6 py-3 rounded-full hover:bg-opacity-90 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1E40AF]">Send</button>
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
            userInput.focus();

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
                    messageElement.textContent = botMessage;
                }

                typingIndicator.classList.add('hidden');
            } catch (error) {
                typingIndicator.classList.add('hidden');
                addMessage('Error connecting to AI. Please try again.', 'bot');
            }
        }

        function addMessage(content, type) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${type} p-4 max-w-[75%] shadow-md`;
            messageDiv.textContent = content;
            messageContainer.appendChild(messageDiv);

            // Trigger reflow to enable transition
            messageDiv.offsetHeight;

            messageDiv.classList.add('show');
            messageContainer.scrollTop = messageContainer.scrollHeight;
            return messageDiv;
        }

        function selectPrompt(prompt) {
            document.getElementById('user-input').value = prompt;
            sendMessage();
        }
    </script>
</body>
</html>
