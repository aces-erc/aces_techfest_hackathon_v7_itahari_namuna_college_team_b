<?php
include_once '../config/db.php';
include_once '../includes/session.php';

// Your OpenRouter API key
$openRouterApiKey = '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';

// Decode incoming JSON
$request = json_decode(file_get_contents('php://input'), true);
$prompt = $request['prompt'] ?? '';

// Function to fetch response from OpenRouter
function getSuggestionFromAI($prompt) {
    $url = 'https://openrouter.ai/api/v1/chat/completions';

    $data = [
        'model' => 'openai/gpt-3.5-turbo',
        'messages' => [
            [
                'role' => 'user',
                'content' => $prompt
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $GLOBALS['openRouterApiKey']
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return "Error: " . curl_error($ch);
    }

    curl_close($ch);

    $responseData = json_decode($response, true);
    
    return $responseData['choices'][0]['message']['content'] ?? "Unable to generate recommendations. Please try again.";
}

// Get AI response
echo getSuggestionFromAI($prompt);
?>
