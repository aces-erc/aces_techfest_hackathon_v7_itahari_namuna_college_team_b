<?php
// Gemini API key and URL
$apiKey = "AIzaSyBoJ8pwhV9TsJTZdGR48ByTz9r9PGF3Kt0";
$apiUrl = "https://generativelanguage.googleapis.com/v1beta2/models/gemini-1.5-flash:generateText?key=$apiKey";

// Get the user query from the request
$requestBody = json_decode(file_get_contents('php://input'), true);
$userQuery = $requestBody['query'] ?? '';

if (!$userQuery) {
    echo json_encode(['reply' => 'Sorry, I did not understand that. Please try again.']);
    exit;
}

// Prepare the request to Gemini API
$requestPayload = [
    "prompt" => [
        "text" => $userQuery
    ]
];

$headers = [
    "Content-Type: application/json"
];

// Initialize cURL
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestPayload));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Get the response
$response = curl_exec($ch);
curl_close($ch);

// Parse the response
$responseData = json_decode($response, true);

// Extract the reply from Gemini API response
$reply = $responseData['candidates'][0]['text'] ?? 'Sorry, I did not understand that. Please try again.';

// Return the reply as JSON
echo json_encode(['reply' => $reply]);
?>
