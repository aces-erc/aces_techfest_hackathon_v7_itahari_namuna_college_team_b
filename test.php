<?php
// Define the API endpoint and your API key
$api_url = "https://api.notdiamond.com/v1/chat/completions";
$api_key = "sk-7ed66467aa10019aeda94b6f25ba705e01d64807912a282b";

// Create the payload for the request
$data = [
    "messages" => [
        ["role" => "user", "content" => "Your message here"]
    ],
    "model" => [
        "openai/gpt-4o-mini",
        "perplexity/llama-3.1-sonar-large-128k-online"
    ],
    "tradeoff" => "cost"
];

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $api_key"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Execute the cURL request
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
} else {
    // Print the API response
    echo "API Response: " . $response;
}

// Close the cURL session
curl_close($ch);
?>
<?php phpinfo(); ?>

