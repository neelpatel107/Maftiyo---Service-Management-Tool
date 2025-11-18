<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $software_id = intval($data['software_id'] ?? 0);
    $comment = trim(htmlspecialchars($data['comment'] ?? ''));
    $rating = intval($data['rating'] ?? 0);
    $user = htmlspecialchars($_SESSION['user']['username'] ?? 'Anonymous');

    if (!$software_id || !$comment || $rating < 1 || $rating > 5) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    $reviews_file = 'reviews.json';
    $reviews = json_decode(file_get_contents($reviews_file), true) ?? [];

    $new_review = [
        'software_id' => $software_id,
        'user' => $user,
        'comment' => $comment,
        'rating' => $rating,
        'date' => date('Y-m-d H:i:s'),
        'approved' => false // Admin approval required
    ];

    $reviews[] = $new_review;

    if (file_put_contents($reviews_file, json_encode($reviews, JSON_PRETTY_PRINT))) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save review']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
