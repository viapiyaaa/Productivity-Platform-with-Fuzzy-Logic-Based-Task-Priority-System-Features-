<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'mindfuljourney';

try {
    $koneksi = new mysqli($host, $username, $password, $database);
    
    if ($koneksi->connect_error) {
        throw new Exception("Tidak dapat terhubung ke database");
    }
} catch (Exception $e) {
    // Tampilkan pesan error yang lebih user-friendly
    die("Maaf, terjadi kesalahan sistem. Silakan coba beberapa saat lagi.");
}
?>