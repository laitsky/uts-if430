<?php
require_once 'header.php';
echo "<div class='container text-center py-3' id='index-body'>";
echo '<img class="img-fluid" src="assets/social_friends.svg" alt="gambar sosial media" style="width: 360px; height: auto;">';
echo "<div class='pt-5'><h1>Selamat datang di proyek UTS Pemrograman Web IF 430</h1>";
if($loggedin) {
    ?>
    <link rel="stylesheet" href="css/index.css">    
    <?php echo $user?>, kamu telah masuk
<?php
}
else {
    ?>
        <h3 class="py-3">Silakan daftar atau masuk</h3>
    <div class="row my-3 mr-auto ml-auto" style="max-width: 560px">
        <div class="col-md-6 mb-3">
            <a href="signup.php" class="btn btn-block btn-primary"><i class="las la-user-plus"></i>Daftar</a>
        </div>
        <div class="col-md-6">
            <a href="login.php" class="btn btn-block btn-success"><i class="las la-sign-in-alt"></i>Masuk</a>
        </div>
    </div>

<?php
}


echo <<<_END
</div><br>
_END;
echo "</div>"; // penutup tag div container
