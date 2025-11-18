<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = trim($data['email']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $subscribers = json_decode(file_get_contents('newsletter.json'), true) ?? [];
        if (!in_array($email, $subscribers)) {
            $subscribers[] = $email;
            file_put_contents('newsletter.json', json_encode($subscribers));
            echo json_encode(['success' => true, 'message' => 'Subscribed successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Already subscribed']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid method']);
}
?>
