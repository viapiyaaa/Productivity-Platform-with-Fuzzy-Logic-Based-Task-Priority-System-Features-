<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $diary_id = isset($_POST['diary_id']) ? (int)$_POST['diary_id'] : 0;
    
    error_log("Attempting to delete diary ID: " . $diary_id);
    
    if ($diary_id > 0) {
        $query = "DELETE FROM diary WHERE diary_id = ?";
        $stmt = $koneksi->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param("i", $diary_id);
            
            if ($stmt->execute()) {
                header("Location: diary.php?status=success&message=Entry berhasil dihapus");
                exit();
            } else {
                error_log("Delete failed: " . $stmt->error);
                header("Location: diary.php?status=error&message=Gagal menghapus entry");
                exit();
            }
        } else {
            error_log("Prepare statement failed: " . $koneksi->error);
            header("Location: diary.php?status=error&message=Database error");
            exit();
        }
    } else {
        error_log("Invalid diary ID: " . $diary_id);
        header("Location: diary.php?status=error&message=Invalid diary ID");
        exit();
    }
} else {
    header("Location: diary.php");
    exit();
}
?> 