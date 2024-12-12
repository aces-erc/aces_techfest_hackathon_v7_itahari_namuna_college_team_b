<?php
include_once '../config/db.php';
include_once '../includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $full_name = trim($_POST['full_name']);
    $payee_account_number = trim($_POST['payee_account_number']);
    $receipt_id = trim($_POST['receipt_id']);
    $amount = 100.00;

    try {
        $stmt = $db->prepare("
            INSERT INTO manual_pay (user_id, full_name, payee_account_number, receipt_id, amount)
            VALUES (:user_id, :full_name, :payee_account_number, :receipt_id, :amount)
        ");
        $stmt->execute([
            ':user_id' => $user_id,
            ':full_name' => $full_name,
            ':payee_account_number' => $payee_account_number,
            ':receipt_id' => $receipt_id,
            ':amount' => $amount,
        ]);

        header("Location: ../view/manualpay_success.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
