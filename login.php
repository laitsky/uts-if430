<?php
require_once 'header.php';
$error = $user = $pass = "";
$captcha;
echo "<div class='container'>";
if (isset($_POST['user'])) {
    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
        if (!$captcha) {
            $error = "Please check the captcha form";
        } else {
            $str = "https://www.google.com/recaptcha/api/siteverify?secret=6Lfm6t8UAAAAAFfjoLsBuZ_BNYmoQyJPtL4yPt57" . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR'];

            $response = file_get_contents($str);
            $response_arr = (array)json_decode($response);

            if ($response_arr['success'] == false) {
                $error = "You are spammer ! GET OUT";
            } else {
                $user = sanitize_string($_POST['user']);
                $pass = sanitize_string(md5($_POST['pass']));

                if ($user == "" || $pass == "")
                    $error = 'Not all fields were entered';
                else {
                    $result = query_my_sql("SELECT user,pass FROM members WHERE user='$user' AND pass='$pass'");

                    if ($result->num_rows == 0) {
                        $error = "Username atau password yang kamu masukkan salah!";
                    } else {
                        $_SESSION['user'] = $user;
                        $_SESSION['pass'] = $pass;
                        die("<meta http-equiv='refresh' content='0;URL=members.php?view=$user'/>");

                    }
                }
            }
        }
    }
}
?>

<div class="row">
    <div class="col-md-6 text-center pt-5">
        <h2>Masuk ke Sosial Media</h2>
        <h4>Mari berinteraksi dengan sesama.</h4>
        <img src="assets/login.svg" class="img-fluid pt-5" alt="login" style="height: 400px; width: auto;">
    </div>
    <div class="col-md-6 pt-5">
        <div class="card card-container my-5 form-placing">
            <h6 class="text-center mt-3">Masuk dengan akun identifikasi kamu.<hr></h6>
            <form method='post' action='login.php'>
                <div class="form-group">
                    <label for="user">Username</label>
                    <input type="text" class="form-control" name="user">
                </div>
                <div class="form-group">
                    <label for="pass">Password</label>
                    <input type="password" class="form-control" name="pass">
                </div>
                <div class="form-group">
                    <div class="g-recaptcha" id="captcha" data-sitekey="6Lfm6t8UAAAAAPGoonYnz7Rmpmq5nOXibNfREfT6" >
                    </div>
                    <div class="form-group">
                        <span class="error"><?php echo $error; ?></span>
                    </div>
                    <button class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>
</div>


</div> <!-- penutup tag div container -->
