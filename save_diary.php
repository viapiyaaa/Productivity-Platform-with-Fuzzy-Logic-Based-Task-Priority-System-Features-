<?php
include 'koneksi.php';

// Cek jika request method adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    $mood = isset($_POST['mood']) ? trim($_POST['mood']) : '';
    
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

    // Jika tidak ada error, simpan ke database
    if (empty($errors)) {
        // Prepare statement untuk mencegah SQL injection
        $query = "INSERT INTO diary (title, content, mood, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $koneksi->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param("sss", $title, $content, $mood);
            
            if ($stmt->execute()) {
                // Redirect ke halaman diary dengan pesan sukses
                header("Location: diary.php?status=success&message=Entry berhasil disimpan");
                exit();
            } else {
                // Redirect dengan pesan error
                header("Location: diary.php?status=error&message=Gagal menyimpan entry");
                exit();
            }
        } else {
            // Redirect dengan pesan error
            header("Location: diary.php?status=error&message=Database error");
            exit();
        }
    } else {
        // Redirect dengan pesan error validasi
        $error_message = urlencode(implode(", ", $errors));
        header("Location: diary.php?status=error&message=" . $error_message);
        exit();
    }
} else {
    // Jika bukan POST request, redirect ke halaman diary
    header("Location: diary.php");
    exit();
}
?> 