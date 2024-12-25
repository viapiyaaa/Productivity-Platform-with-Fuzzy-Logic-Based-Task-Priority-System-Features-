<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Debug log
        error_log('Received delete request for task ID: ' . $_POST['task_id']);
        
        if (!isset($_POST['task_id'])) {
            throw new Exception('Task ID is required');
        }
        
        $task_id = $_POST['task_id'];
        
        $sql = "DELETE FROM todo WHERE task_id = ?";
        $stmt = $koneksi->prepare($sql);
        
        if (!$stmt) {
            throw new Exception('Failed to prepare statement');
        }
        
        $stmt->bind_param("i", $task_id);
        
        if (!$stmt->execute()) {
            throw new Exception('Failed to execute delete query');
        }
        
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Task berhasil dihapus'
            ]);
        } else {
            throw new Exception('Task not found or already deleted');
        }
        
        $stmt->close();
    } catch (Exception $e) {
        error_log('Error in delete_task.php: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menghapus task. ' . $e->getMessage()
        ]);
    }
}
?> 