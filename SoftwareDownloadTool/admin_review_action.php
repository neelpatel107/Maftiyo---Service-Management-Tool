<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'];
    $index = intval($data['index']);

    $reviews_file = 'reviews.json';
    $reviews = json_decode(file_get_contents($reviews_file), true) ?? [];

    if ($action === 'approve') {
        if (isset($reviews[$index])) {
            $reviews[$index]['approved'] = true;
            if (file_put_contents($reviews_file, json_encode($reviews, JSON_PRETTY_PRINT))) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to save']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Review not found']);
        }
    } elseif ($action === 'reject') {
        if (isset($reviews[$index])) {
            unset($reviews[$index]);
            $reviews = array_values($reviews); // reindex
            if (file_put_contents($reviews_file, json_encode($reviews, JSON_PRETTY_PRINT))) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to save']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Review not found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid method']);
}
?>
