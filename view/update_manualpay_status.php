<?php
include_once '../config/db.php';
include_once '../includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && $_POST['action'] === 'mark_paid') {
    $id = $_POST['id'];

    try {
        $stmt = $db->prepare("UPDATE manual_pay SET status = 'paid' WHERE id = :id");
        $stmt->execute([':id' => $id]);

        header("Location: order_verify.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
