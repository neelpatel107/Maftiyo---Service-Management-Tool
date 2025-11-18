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

    $subscribers_file = 'newsletter.json';
    $subscribers = json_decode(file_get_contents($subscribers_file), true) ?? [];

    if ($action === 'remove') {
        if (isset($subscribers[$index])) {
            unset($subscribers[$index]);
            $subscribers = array_values($subscribers); // reindex
            if (file_put_contents($subscribers_file, json_encode($subscribers))) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to save']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Subscriber not found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid method']);
}
?>
