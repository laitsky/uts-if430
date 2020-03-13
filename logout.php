<?php
require_once 'header.php';
if (isset($_SESSION['user'])) {
    destroy_session();
    ?>
    <meta http-equiv="refresh" content="0;URL=index.php"/>
    <?php
} else echo "<div class='text-center'>Kamu tidak bisa keluar karena kamu belum masuk</div>";
?>
