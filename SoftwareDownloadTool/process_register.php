<?php
session_start();
$users = json_decode(file_get_contents('users.json'), true) ?? [];
$user = [
  'id' => uniqid(),
  'fname' => $_POST['fname'],
  'lname' => $_POST['lname'],
  'mname' => $_POST['mname'],
  'email' => $_POST['email'],
  'phone' => $_POST['phone'],
  'dob' => $_POST['dob'],
  'address' => $_POST['address'],
  'upiId' => $_POST['upiId'],
  'password' => $_POST['password']
];
$users[] = $user;
file_put_contents('users.json', json_encode($users));
header('Location: login.php');
?>
