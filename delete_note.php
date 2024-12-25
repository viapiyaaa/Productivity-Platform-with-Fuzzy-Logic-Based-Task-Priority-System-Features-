<?php

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = array();
    
    try {
        $note_id = $_POST['id'];
        
        $sql = "DELETE FROM notes WHERE id = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->execute([$note_id]);
        
        $response = array(
            'status' => 'success',
            'message' => 'Note berhasil dihapus'
        );
        
    } catch(Exception $e) {
        $response = array(
            'status' => 'error',
            'message' => $e->getMessage()
        );
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
}
?> 