<?php
// Database configuration
$host = 'localhost';       // Database host
$dbname = 'Gyanfit';         // Database name
$username = 'root';        // Database username
$password = '';            // Database password (update if needed)

try {
    // Create a new PDO instance
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Set error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set fetch mode to associative array by default
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Optional: Set persistent connection (for better performance)
    $db->setAttribute(PDO::ATTR_PERSISTENT, true);
} catch (PDOException $e) {
    // Handle connection error
    die("Database connection failed: " . $e->getMessage());
}
?>
