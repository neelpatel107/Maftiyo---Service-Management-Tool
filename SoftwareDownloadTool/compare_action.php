<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $action = $data['action'];

    if (!isset($_SESSION['compare'])) {
        $_SESSION['compare'] = [];
    }

    if ($action === 'add' && !in_array($id, $_SESSION['compare'])) {
        $_SESSION['compare'][] = $id;
    } elseif ($action === 'remove') {
        $_SESSION['compare'] = array_filter($_SESSION['compare'], fn($c) => $c != $id);
    }

    echo json_encode(['success' => true, 'count' => count($_SESSION['compare'])]);
} else {
    echo json_encode(['success' => false]);
}
?>
