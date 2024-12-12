<?php 
// OpenRouter API Key
$apiKey = "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";
$apiUrl = "https://openrouter.ai/api/v1/chat/completions";

// Get the user's message from the POST request
$requestData = json_decode(file_get_contents('php://input'), true);
$userMessage = $requestData['query'] ?? '';

if (!$userMessage) {
    echo json_encode(['reply' => 'कुनै इनपुट प्रदान गरिएको छैन। कृपया प्रयास गर्नुहोस्।']);
    exit;
}

// Load Pre-trained Model and Tokenizer
$model = json_decode(file_get_contents('../path/to/saved-model.json'), true);
$tokenizer = json_decode(file_get_contents('../path/to/saved-tokenizer.json'), true);

// Predict Category
$category = predictCategory($userMessage, $model, $tokenizer);

// Define Responses
$responses = [
    'name' => 'मेरो नाम Gyan Fit हो।',
    'help' => 'म तपाईंलाई मद्दत गर्न सक्छु।',
    'greeting' => 'नमस्ते! म तपाईंलाई कसरी सहयोग गर्न सक्छु?',
    'fallback' => 'माफ गर्नुहोस्, म तपाईंको अनुरोध बुझ्न असमर्थ छु।',
];

// Return AI Response
$response = $responses[$category] ?? $responses['fallback'];
echo json_encode(['reply' => $response]);

function predictCategory($query, $model, $tokenizer) {
    // Use TensorFlow.js output for prediction (mocked for backend demo)
    return 'help'; // Replace with actual model inference logic
}
?>
