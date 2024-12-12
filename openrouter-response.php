<?php
// OpenRouter API Key
$apiKey = "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";
$apiUrl = "https://openrouter.ai/api/v1/chat/completions";

// Get the user's message from the POST request
$requestData = json_decode(file_get_contents('php://input'), true);
$userMessage = $requestData['query'] ?? '';

if (!$userMessage) {
    echo json_encode(['reply' => 'No input provided.']);
    exit;
}

// Prepare payload for OpenRouter API
$data = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => "You are a helpful assistant."],
        ["role" => "user", "content" => $userMessage],
    ],
    "temperature" => 0.7,
    "max_tokens" => 150,
];

// Make API request to OpenRouter
$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\nAuthorization: Bearer $apiKey\r\n",
        'method'  => 'POST',
        'content' => json_encode($data),
    ],
];

$context  = stream_context_create($options);
$response = file_get_contents($apiUrl, false, $context);

if ($response === FALSE) {
    echo json_encode(['reply' => 'Failed to fetch AI response.']);
    exit;
}

// Decode and send the response
$responseData = json_decode($response, true);
$aiReply = $responseData['choices'][0]['message']['content'] ?? "Sorry, I couldn't process your request.";
echo json_encode(['reply' => $aiReply]);
