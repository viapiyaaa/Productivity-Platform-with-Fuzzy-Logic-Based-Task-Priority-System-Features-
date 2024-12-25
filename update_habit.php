<?php
session_start();
$koneksi = mysqli_connect("localhost", "username", "password", "habits_tubes");

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $habit_id = mysqli_real_escape_string($koneksi, $_POST['habit_id']);
    $day = mysqli_real_escape_string($koneksi, $_POST['day']);
    $completed = mysqli_real_escape_string($koneksi, $_POST['completed']);

    $query = "UPDATE habits SET day$day = $completed WHERE id = $habit_id";
    
    if (mysqli_query($koneksi, $query)) {
        // Update completed count
        $query = "UPDATE habits SET completed = (day1 + day2 + day3 + day4 + day5 + day6 + day7) WHERE id = $habit_id";
        mysqli_query($koneksi, $query);
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

mysqli_close($koneksi); 