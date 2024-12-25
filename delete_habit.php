<?php
session_start();
$koneksi = mysqli_connect("localhost", "username", "password", "habits_tubes");

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $habit_id = mysqli_real_escape_string($koneksi, $_POST['habit_id']);
    
    $query = "DELETE FROM habits WHERE id = $habit_id";
    
    if (mysqli_query($koneksi, $query)) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

mysqli_close($koneksi); 