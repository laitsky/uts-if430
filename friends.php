<?php
require_once 'header.php';

if (!$loggedin) die("<div class='text-center'><h1>Kamu tidak dapat mengakses halaman ini!</h1></div>");

if(isset($_GET['view'])) $view = sanitize_string($_GET['view']);
else $view = $user;

if ($view == $user)
{
    $name1 = $name2 = "Your";
}
