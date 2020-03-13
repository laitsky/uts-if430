<?php
require_once 'header.php';
echo "<div class='container'>";
echo "<div>Selamat datang di projek UTS PemWeb,";
if($loggedin) {
    ?>
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
