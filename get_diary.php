<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $query = "SELECT diary_id, title, content, mood FROM diary WHERE diary_id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        header('Content-Type: application/json');
        echo json_encode($row);
    } else {
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Entry not found']);
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'ID is required']);
}
?> 