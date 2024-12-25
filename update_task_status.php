<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Debug log
        error_log('Received POST request: ' . print_r($_POST, true));

        $task_id = $_POST['task_id'];
        $is_completed = $_POST['is_completed'];

        $sql = "UPDATE todo SET is_completed = ? WHERE task_id = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("ii", $is_completed, $task_id);

        // Debug log
        error_log('Executing SQL: ' . $sql);
        
        if (!$stmt->execute()) {
            throw new Exception("Gagal mengupdate task: " . $stmt->error);
        }

        $affected_rows = $stmt->affected_rows;
        
        // Debug log
        error_log('Task updated. Affected rows: ' . $affected_rows);

        echo json_encode([
            'status' => 'success',
            'message' => 'Task berhasil diupdate'
        ]);

        $stmt->close();
    } catch (Exception $e) {
        error_log('Error in update_task_status.php: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal mengupdate task. Silakan coba lagi.'
        ]);
    }
}
?>
