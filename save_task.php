<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Debug log
        error_log('Received POST request: ' . print_r($_POST, true));

        $task_name = $_POST['task_name'];
        $tag = $_POST['tag'];
        
        if ($tag === 'tugas') {
            $due_date = $_POST['due_date'];
            $sql = "INSERT INTO todo (task_name, tag, due_date) VALUES (?, ?, ?)";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("sss", $task_name, $tag, $due_date);
        } else {
            $sql = "INSERT INTO todo (task_name, tag) VALUES (?, ?)";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("ss", $task_name, $tag);
        }
        
        // Debug log
        error_log('Executing SQL: ' . $sql);
        
        if (!$stmt->execute()) {
            throw new Exception("Gagal menyimpan task: " . $stmt->error);
        }
        
        $task_id = $koneksi->insert_id;
        
        // Debug log
        error_log('Task saved with ID: ' . $task_id);
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Task berhasil ditambahkan',
            'task_id' => $task_id
        ]);
        
        $stmt->close();
    } catch (Exception $e) {
        error_log('Error in save_task.php: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menambahkan task. Silakan coba lagi.'
        ]);
    }
}
?> 