<?php
include_once '../config/db.php'; // Include database connection
require_once '../vendor/autoload.php'; // Load PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']); // Ensure email is collected
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $age = $_POST['age'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $weekly_activities = $_POST['weekly_activities'];

    // Validate inputs
    $errors = [];
    if (empty($full_name)) $errors[] = "Full name is required.";
    if (empty($phone)) $errors[] = "Phone number is required.";
    if (empty($email)) $errors[] = "Email is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if (empty($password)) $errors[] = "Password is required.";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match.";
    if (empty($age) || $age <= 0) $errors[] = "Valid age is required.";
    if (empty($weight) || $weight <= 0) $errors[] = "Valid weight is required.";
    if (empty($height) || $height <= 0) $errors[] = "Valid height is required.";
    if (empty($weekly_activities)) $errors[] = "Weekly activity level is required.";

    // If there are validation errors, redirect back with errors
    if (!empty($errors)) {
        $error_message = urlencode(implode(", ", $errors));
        header("Location: ../view/signup.php?errors=$error_message");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Calculate BMI
    $bmi = $weight / (($height / 100) ** 2);

    // Calculate Protein and Calories Goals
    $protein_goal = ($weekly_activities === 'highly_active') ? $weight * 2 : ($weekly_activities === 'active' ? $weight * 1.8 : $weight * 1.6);
    $calories_goal = ($weekly_activities === 'highly_active') ? $weight * 35 : ($weekly_activities === 'active' ? $weight * 30 : $weight * 25);

    // Calculate Recommended Weight (based on BMI of 22.5)
    $recommended_weight = 22.5 * (($height / 100) ** 2);

    // Insert user data into the database
    try {
        // Begin transaction
        $db->beginTransaction();

        // Insert into users table
        $stmt = $db->prepare("
            INSERT INTO users 
            (full_name, phone, email, password, age, weight, height, weekly_activities, status) 
            VALUES 
            (:full_name, :phone, :email, :password, :age, :weight, :height, :weekly_activities, 'active')
        ");
        $stmt->execute([
            ':full_name' => $full_name,
            ':phone' => $phone,
            ':email' => $email,
            ':password' => $hashed_password,
            ':age' => $age,
            ':weight' => $weight,
            ':height' => $height,
            ':weekly_activities' => $weekly_activities,
        ]);

        // Get the last inserted user ID
        $user_id = $db->lastInsertId();

        // Insert into body_stats table
        $stmt = $db->prepare("
            INSERT INTO body_stats 
            (user_id, bmi, protein_goal, calories_goal, weight_recommendation) 
            VALUES 
            (:user_id, :bmi, :protein_goal, :calories_goal, :weight_recommendation)
        ");
        $stmt->execute([
            ':user_id' => $user_id,
            ':bmi' => $bmi,
            ':protein_goal' => $protein_goal,
            ':calories_goal' => $calories_goal,
            ':weight_recommendation' => $recommended_weight,
        ]);

        // Commit transaction
        $db->commit();

        // Set session variables for the registered user
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['full_name'] = $full_name;

        // Send "Registration Completed" email
        $mail = new PHPMailer(true);
        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com'; // Update with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'gyanfit@nutrinexas.com'; // Update with your email
            $mail->Password = 'm&VL1Lo4'; // Update with your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Sender and recipient
            $mail->setFrom('gyanfit@nutrinexas.com', 'Gyanfit Team');
            $mail->addAddress($email, $full_name);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Gyanfit!';
            $mail->Body = file_get_contents('../email/welcome.html'); // Template
            $mail->Body = str_replace(
                ['{{full_name}}', '{{email}}', '{{bmi}}'],
                [$full_name, $email, round($bmi, 2)],
                $mail->Body
            );

            $mail->send();
        } catch (Exception $e) {
            // Log email errors (if needed)
            error_log("Email error: " . $mail->ErrorInfo);
        }

        // Redirect directly to dashboard
        header("Location: ../view/dashboard.php");
        exit();
    } catch (PDOException $e) {
        // Rollback transaction on error
        $db->rollBack();

        // Handle database errors
        $error_message = urlencode("Database error: " . $e->getMessage());
        header("Location: ../view/signup.php?errors=$error_message");
        exit();
    }
}
?>

