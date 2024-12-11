<?php
include_once '../config/db.php';

$query = $_GET['query'] ?? '';
if (!empty($query)) {
    try {
        $stmt = $db->prepare("SELECT * FROM nutrition WHERE food_name LIKE :query LIMIT 10");
        $stmt->execute([':query' => '%' . $query . '%']);
        $foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($foods);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
//search_nutrition