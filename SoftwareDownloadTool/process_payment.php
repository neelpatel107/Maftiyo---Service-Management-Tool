<?php
session_start();
$id = $_POST['id'];
$method = $_POST['method'];
if($method == 'upi') {
  header("Location: qr.php?id=$id");
} else {
  // Simulate success
  $_SESSION['downloads'][] = $id;
  header('Location: account.php');
}
?>
