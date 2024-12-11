<?php
include_once '../config/db.php';
include_once '../includes/session.php';

// OpenRouter API key
$openRouterApiKey = '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';
// Gemini API key
$apiKey = "AIzaSyBoJ8pwhV9TsJTZdGR48ByTz9r9PGF3Kt0";

$request = json_decode(file_get_contents('php://input'), true);
$prompt = $request['prompt'] ?? '';

$user_id = $_SESSION['user_id'];

// Fetch user data
try {
    $stmtUser = $db->prepare("SELECT full_name, age, height, weight FROM users WHERE user_id = :user_id");
    $stmtUser->execute([':user_id' => $user_id]);
    $userData = $stmtUser->fetch(PDO::FETCH_ASSOC);

    $stmtStats = $db->prepare("SELECT * FROM body_stats WHERE user_id = :user_id");
    $stmtStats->execute([':user_id' => $user_id]);
    $bodyStats = $stmtStats->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        echo json_encode(['error' => 'User not found.']);
        exit();
    }

    $userContext = "User Info:\n";
    $userContext .= "Full Name: {$userData['full_name']}\n";
    $userContext .= "Age: {$userData['age']} years\n";
    $userContext .= "Height: {$userData['height']} cm\n";
    $userContext .= "Weight: {$userData['weight']} kg\n";

    if ($bodyStats) {
        $userContext .= "Additional Stats:\n";
        foreach ($bodyStats as $key => $value) {
            if ($key !== 'user_id' && $key !== 'id') {
                $userContext .= ucfirst(str_replace('_', ' ', $key)) . ": $value\n";
            }
        }
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error fetching user data: ' . $e->getMessage()]);
    exit();
}

// Combine user context with the prompt
$fullPrompt = $userContext . "\nUser's Query: " . $prompt;

// Function to fetch response from OpenRouter
function getOpenRouterResponse($prompt) {
    $url = 'https://openrouter.ai/api/v1/chat/completions';

    $data = [
        'model' => 'openai/gpt-3.5-turbo',
        'messages' => [
            ['role' => 'system', 'content' => 'You are a concise nutrition expert. Keep your responses under 70 words.'],
            ['role' => 'user', 'content' => $prompt]
        ],
        'max_tokens' => 70 // Limit to 70 words
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
        return null; // Return null to indicate failure
    }

    curl_close($ch);

    $responseData = json_decode($response, true);
    
    return $responseData['choices'][0]['message']['content'] ?? null;
}

// Function to fetch response from Gemini API
function getGeminiResponse($prompt) {
    $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $GLOBALS['apiKey'];

    $data = [
        "prompt" => [
            "text" => $prompt
        ],
        "temperature" => 0.7,
        "maxOutputTokens" => 70 // Limit to 70 words
    ];

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return null; // Return null to indicate failure
    }

    curl_close($ch);

    $responseData = json_decode($response, true);
    
    return $responseData['candidates'][0]['output'] ?? null;
}

// Main logic to use fallback
$response = getOpenRouterResponse($fullPrompt);
if (!$response) {
    // If OpenRouter fails, fallback to Gemini
    $response = getGeminiResponse($fullPrompt);
}

// If both fail, return an error message
if (!$response) {
    $response = "Unable to generate recommendations. Please try again later.";
}

// Output the response
echo $response;
?>
