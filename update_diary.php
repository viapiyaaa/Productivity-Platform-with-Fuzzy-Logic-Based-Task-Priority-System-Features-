<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $diary_id = isset($_POST['diary_id']) ? (int)$_POST['diary_id'] : 0;
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    $mood = isset($_POST['mood']) ? trim($_POST['mood']) : '';
    
    // Debugging
    error_log("POST data received:");
    error_log("diary_id: " . $diary_id);
    error_log("title: " . $title);
    error_log("content: " . $content);
    error_log("mood: " . $mood);
    
    // Validasi data
    $errors = [];
    if (empty($title)) {
        $errors[] = "Title is required";
    }
    if (empty($content)) {
        $errors[] = "Content is required";
    }
    if (empty($mood)) {
        $errors[] = "Mood is required";
    }
    if ($diary_id <= 0) {
        $errors[] = "Invalid diary ID";
    }
    
    if (!empty($errors)) {
        error_log("Validation errors: " . implode(", ", $errors));
    }
    
    if (empty($errors)) {
        $query = "UPDATE diary SET title = ?, content = ?, mood = ? WHERE diary_id = ?";
        error_log("SQL Query: " . $query);
        $stmt = $koneksi->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param("sssi", $title, $content, $mood, $diary_id);
            
            if ($stmt->execute()) {
                error_log("Update successful for diary_id: " . $diary_id);
                header("Location: diary.php?status=success&message=Entry berhasil diupdate");
                exit();
            } else {
                error_log("Update failed: " . $stmt->error);
                header("Location: diary.php?status=error&message=Gagal mengupdate entry: " . $stmt->error);
                exit();
            }
        } else {
            error_log("Prepare statement failed: " . $koneksi->error);
            header("Location: diary.php?status=error&message=Database error: " . $koneksi->error);
            exit();
        }
    } else {
        $error_message = urlencode(implode(", ", $errors));
        header("Location: diary.php?status=error&message=" . $error_message);
        exit();
    }
} else {
    header("Location: diary.php");
    exit();
}
?> 