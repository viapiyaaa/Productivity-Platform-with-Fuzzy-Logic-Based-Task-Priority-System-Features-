<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "habits_tubes");

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $habit_id = (int)mysqli_real_escape_string($koneksi, $_POST['habit_id']);
    $habit_name = mysqli_real_escape_string($koneksi, $_POST['habit_name']);
    $goal = (int)mysqli_real_escape_string($koneksi, $_POST['goal']);
    
    if(empty($habit_name)) {
        echo "Invalid habit name";
        exit;
    }

    if($goal <= 0 || $goal > 7) {
        echo "Goal must be between 1 and 7 days";
        exit;
    }
    
    $query = "UPDATE habits SET habit_name = ?, goal = ? WHERE id = ?";
              
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "sii", $habit_name, $goal, $habit_id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
    
    mysqli_stmt_close($stmt);
}

mysqli_close($koneksi);
?> 