<?php
session_start();
include 'config.php';

$bundle_id = $_POST['bundle_id'];
$method = $_POST['method'];

$offer = array_filter($bestOffers, fn($o) => $o['id'] == $bundle_id);
$offer = reset($offer);

if($offer) {
  if($method == 'upi') {
    header("Location: qr.php?bundle_id=$bundle_id");
  } else {
    // Simulate success - add all bundle items to downloads
    if(!isset($_SESSION['downloads'])) {
      $_SESSION['downloads'] = [];
    }

    foreach($offer['items'] as $itemId) {
      if(!in_array($itemId, $_SESSION['downloads'])) {
        $_SESSION['downloads'][] = $itemId;
      }
    }

    // Also store bundle purchase info
    if(!isset($_SESSION['bundle_purchases'])) {
      $_SESSION['bundle_purchases'] = [];
    }
    $_SESSION['bundle_purchases'][] = [
      'bundle_id' => $bundle_id,
      'purchase_date' => date('Y-m-d H:i:s'),
      'items' => $offer['items']
    ];

    header('Location: account.php?bundle_success=1');
  }
} else {
  header('Location: index.php');
}
?>
