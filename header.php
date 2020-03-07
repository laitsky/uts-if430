<?php
session_start();

echo <<<_INIT
<!DOCTYPE html> 
<html>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'> 
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

_INIT;

require_once 'functions.php';

$userstr = 'Selamat Datang';

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr = "Logged in as: $user";
} else $loggedin = FALSE;

echo <<<_MAIN
<title>UTS PemWeb IF430 - $userstr </title>
</head>
<body>
<div class="container">
<section id="header">
<div id="header-logo">Sosial Media</div>
<div id="header-username">$userstr</div>
</section>
<section id="content">
_MAIN;

if ($loggedin) {
    echo <<<_LOGGEDIN
<div class="text-center">
<a href="members.php?view=$user">Home</a>
<a href="members.php">Members</a>
<a href="friends.php">Friends</a>
<a href="messages.php">Messages</a>
<a href="profile.php">Edit Profile</a>
<a href="logout.php">Log Out</a>
</div>
_LOGGEDIN;
} else {
    echo <<<_GUEST
<div class="text-center">
<a href="index.php">Home</a>
<a href="signup.php">Sign Up</a>
<a href="login.php">Log In</a>
<p>Kamu harus masuk untuk menggunakan aplikasi ini.</p>
</div>
_GUEST;

}

?>
