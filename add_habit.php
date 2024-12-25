<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "mindfuljourney");

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $habit_name = mysqli_real_escape_string($koneksi, $_POST['habit_name']);
    $goal = (int)mysqli_real_escape_string($koneksi, $_POST['goal']);
    $week = (int)mysqli_real_escape_string($koneksi, $_POST['week']);
    $month = mysqli_real_escape_string($koneksi, $_POST['month']);
    $year = (int)mysqli_real_escape_string($koneksi, $_POST['year']);
    
    if(empty($habit_name)) {
        echo "Invalid habit name";
        exit;
    }

    if($goal <= 0 || $goal > 7) {
        echo "Goal must be between 1 and 7 days";
        exit;
    }
    
    $query = "INSERT INTO habits (habit_name, goal, completed, day1, day2, day3, day4, day5, day6, day7, week, month, year) 
              VALUES (?, ?, 0, 0, 0, 0, 0, 0, 0, 0, ?, ?, ?)";
              
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "siisi", $habit_name, $goal, $week, $month, $year);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
    
    mysqli_stmt_close($stmt);
}

mysqli_close($koneksi);
?> 