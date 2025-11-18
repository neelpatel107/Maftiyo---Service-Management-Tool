<?php
session_start();
$users = json_decode(file_get_contents('users.json'), true) ?? [];
$email = $_POST['email'];
$password = $_POST['password'];
$user = array_filter($users, fn($u) => $u['email'] == $email && $u['password'] == $password);
if($user) {
  $_SESSION['user'] = reset($user);
  header('Location: account.php');
} else {
  echo 'Invalid credentials';
}
?>
