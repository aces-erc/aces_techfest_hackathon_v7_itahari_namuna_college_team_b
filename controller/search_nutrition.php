<?php
include_once '../config/db.php';

$query = $_GET['query'] ?? '';
if (!empty($query)) {
    try {
        $stmt = $db->prepare("SELECT food_name, protein, calorie FROM nutrition WHERE food_name LIKE :query LIMIT 10");
        $stmt->execute([':query' => '%' . htmlspecialchars($query, ENT_QUOTES, 'UTF-8') . '%']);
        $foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($foods);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
