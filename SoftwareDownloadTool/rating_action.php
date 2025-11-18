<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;
$rating = intval($data['rating'] ?? 0);

if (!$id || $rating < 1 || $rating > 5) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

if (!isset($_SESSION['ratings'])) {
    $_SESSION['ratings'] = [];
}

$_SESSION['ratings'][$id] = $rating;

echo json_encode(['success' => true, 'message' => 'Rating saved']);
?>
