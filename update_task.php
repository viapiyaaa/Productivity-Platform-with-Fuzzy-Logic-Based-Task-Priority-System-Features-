<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $task_id = $_POST['task_id'];
        $task_name = $_POST['task_name'];
        $tag = $_POST['tag'];
        
        if ($tag === 'tugas') {
            $due_date = $_POST['due_date'];
            $sql = "UPDATE todo SET task_name = ?, tag = ?, due_date = ? WHERE task_id = ?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("sssi", $task_name, $tag, $due_date, $task_id);
        } else {
            $sql = "UPDATE todo SET task_name = ?, tag = ?, due_date = NULL WHERE task_id = ?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("ssi", $task_name, $tag, $task_id);
        }
        
        if (!$stmt->execute()) {
            throw new Exception("Gagal mengupdate task");
        }
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Task berhasil diupdate'
        ]);
        
        $stmt->close();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal mengupdate task. Silakan coba lagi.'
        ]);
    }
}
?> 