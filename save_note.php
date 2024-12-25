<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = array();
    
    try {
        $note_text = $_POST['text'];
        // Menggunakan waktu Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');
        $current_time = date('Y-m-d H:i:s');
        
        $sql = "INSERT INTO notes (note_text, note_time) VALUES (?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->execute([$note_text, $current_time]);
        
        $note_id = $koneksi->insert_id;
        
        // Format waktu dan tanggal untuk ditampilkan dalam Bahasa Indonesia
        setlocale(LC_TIME, 'id_ID');
        $display_time = date('H:i', strtotime($current_time)); // Format 24 jam
        $display_date = strftime('%d %B %Y', strtotime($current_time)); // Format tanggal Indonesia
        
        $response = array(
            'status' => 'success',
            'data' => array(
                'id' => $note_id,
                'text' => $note_text,
                'time' => $display_time,
                'date' => $display_date
            )
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