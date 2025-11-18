<?php
header('Content-Type: application/json');
include 'config.php';

$action = $_GET['action'] ?? '';

if ($action === 'software') {
    echo json_encode($software);
} elseif ($action === 'offers') {
    echo json_encode($bestOffers);
} else {
    echo json_encode(['error' => 'Invalid action']);
}
?>
