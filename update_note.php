<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = array();
    
    try {
        $note_id = $_POST['id'];
        $note_text = $_POST['text'];
        
        $sql = "UPDATE notes SET note_text = ? WHERE id = ?";
        $stmt = $koneksi->prepare($sql);
        $result = $stmt->execute([$note_text, $note_id]);
        
        if ($result) {
            $response = array(
                'status' => 'success',
                'message' => 'Note berhasil diupdate',
                'data' => array(
                    'id' => $note_id,
                    'text' => $note_text
                )
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Gagal mengupdate note'
            );
        }
        
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