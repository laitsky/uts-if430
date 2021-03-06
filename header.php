<?php
session_start();
error_reporting(0);

echo <<<_INIT
<!DOCTYPE html> 
<html>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'> 
    
<link rel="stylesheet" href="styles.css">    
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
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
<nav class="navbar navbar-expand-lg navbar-dark bg-primary py-3">
<a class="navbar-brand" href="index.php" style="text-transform: uppercase; letter-spacing: 4px; font-size: 16px;">Sosial Media</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbar">
<ul class="navbar-nav">
_MAIN;

if ($loggedin) {
    echo <<<_LOGGEDIN
<li class="nav-item">
<a class="nav-link font-weight-bold" href="members.php?view=$user"><i class="las la-home"></i>Beranda</a>
</li>
<li class="nav-item">
<a class="nav-link font-weight-bold" href="messages.php"><i class="las la-stream"></i>Timeline</a>
</li>
<li class="nav-item">
<a class="nav-link font-weight-bold" href="members.php"><i class="las la-users"></i>Anggota</a>
</li>
<li class="nav-item">
<a class="nav-link font-weight-bold" href="friends.php"><i class="las la-user-friends"></i>Teman</a>
</li>
<li class="nav-item">
<a class="nav-link font-weight-bold" href="editProfile.php"><i class="las la-user-circle"></i>Edit Profile</a>
</li>
<li class="nav-item">
<a class="nav-link font-weight-bold" href="profil_kelompok.php"><i class="las la-address-card"></i>Profil Kelompok</a>
</li>
<li class="nav-item">
<a class="nav-link font-weight-bold" href="logout.php"><i class="las la-sign-out-alt"></i>Log Out</a>
</li>
_LOGGEDIN;
} else {
    echo <<<_GUEST
<li class="nav-item">
<a class="nav-link font-weight-bold" href="signup.php"><i class="las la-user-plus"></i>Daftar</a>
</li>
<li class="nav-item">
<a class="nav-link font-weight-bold" href="login.php"><i class="las la-sign-in-alt"></i>Masuk</a>
</li>
_GUEST;

}

echo <<<_CLOSINGTAG
</ul>
</div>
</nav>
_CLOSINGTAG;

?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
