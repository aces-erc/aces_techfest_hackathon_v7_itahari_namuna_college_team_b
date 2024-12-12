<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login page if the user is not logged in
if (empty($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Access user data from the session
$user_id = $_SESSION['user_id'];
$full_name = $_SESSION['full_name'] ?? ''; // Use null coalescing for safety
?>
