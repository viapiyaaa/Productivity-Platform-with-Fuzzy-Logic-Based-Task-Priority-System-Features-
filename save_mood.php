<?php
include 'koneksi.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['date']) && isset($data['mood'])) {
    $date = $koneksi->real_escape_string($data['date']);
    $mood = $koneksi->real_escape_string($data['mood']);
    $note = $koneksi->real_escape_string($data['note'] ?? '');

    $query = "INSERT INTO mood_tracker (date, mood, note) VALUES (?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("sss", $date, $mood, $note);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Mood saved successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save mood']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
}
?> 