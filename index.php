<?php
require_once 'header.php';
echo "<div class='container text-center' id='index-body'>";
echo "<div>Selamat datang di projek UTS PemWeb,";
if($loggedin) {
    ?>
    <link rel="stylesheet" href="css/index.css">    
    <?php echo $user?>, kamu telah masuk
<?php
}
else {
    ?>
    <h3>Silakan daftar atau masuk</h3>
<?php
}


echo <<<_END
</div><br>
_END;
echo "</div>"; // penutup tag div container
