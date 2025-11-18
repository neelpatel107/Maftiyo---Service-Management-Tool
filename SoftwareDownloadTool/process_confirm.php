<?php
session_start();
include 'config.php';

$id = $_POST['id'] ?? null;
$bundle_id = $_POST['bundle_id'] ?? null;

if($bundle_id) {
  $offer = array_filter($bestOffers, fn($o) => $o['id'] == $bundle_id);
  $offer = reset($offer);
  if($offer) {
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
  } else {
    header('Location: index.php');
  }
} elseif($id) {
  $_SESSION['downloads'][] = $id;
  header('Location: account.php');
} else {
  header('Location: index.php');
}
?>
