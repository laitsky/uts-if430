<?php
require_once 'header.php';

echo <<<_END
  <script>
    function checkUser(user)
    {
      if (user.value == '')
      {
        $('#used').html('&nbsp;')
        return
      }

      $.post
      (
        'checkuser.php',
        { user : user.value },
        function(data)
        {
          $('#used').html(data)
        }
      )
    }
  </script>  
_END;
echo "<div class='container'>";
$error = $user = $pass = $first_name = $birth_date = $gender = "";

function has_empty_fields()
{
    if ($user = "" || $pass = "" || $first_name || $birth_date || $gender) {
        return true;
    }
    return false;
}

if (isset($_SESSION['user'])) destroy_session();

if (isset($_POST['user'])) {
    $first_name = sanitize_string($_POST['first_name']);
    $last_name = sanitize_string($_POST['last_name']);
    $user = sanitize_string($_POST['user']);
    $birth_date = sanitize_string($_POST['birth_date']);
    $gender = sanitize_string($_POST['gender']);
    $pass = sanitize_string(md5($_POST['pass']));

    if (has_empty_fields())
        $error = 'Masukkan semua data yang diperlukan!<br><br>';
    else {
        $result = query_my_sql("SELECT * FROM members WHERE user='$user'");

        if ($result->num_rows)
            $error = 'Maaf, username telah dipakai!<br><br>';
        else {
            query_my_sql("INSERT INTO members VALUES('$user', '$first_name', '$last_name', '$birth_date', '$gender', '$pass')");
            die('<h4>Akun telah dibuat</h4>Silakan masuk.');
        }
    }
}
echo <<<_END
<div class="signUp">
  <h1>SIGN UP</h1>
  <hr>
  <form method='post' action='signup.php'>
  <div class="form-group">
  <label for="first_name" >Nama Depan</label>
  <input type="text" class="form-control" name="first_name" value="$first_name" maxlength="20">
  </div>
  <div class="form-group">
  <label for="last_name">Nama Belakang (opsional)</label>
  <input type="text" class="form-control" name="last_name" value="$last_name" maxlength="20">
  </div>
  <div class="form-group">
  <label for="user">Username</label>
  <input type="text" class="form-control" name="user" value="$user" onblur="checkUser(this)" maxlength="16">
  <div id="used">&nbsp;</div>
  </div>
  <div class="form-group">
  <label for="birth_date">Tanggal Lahir</label>
  <input type="date" class="form-control" name="birth_date" value="$birth_date">
  </div>
  <div class="form-group">
  <label for="gender">Jenis Kelamin</label>
  <select name="gender" class="custom-select" >
  <option selected disabled>Pilih jenis kelamin...</option>
  <option value="L">Laki-laki</option>
  <option value="P">Perempuan</option>
  </select>
  </div>
  <div class="form-group">
  <label for="pass">Kata Sandi</label>
  <input type="password" class="form-control" name="pass" value="$pass">
  </div>
  <div class="error">$error</div>
  <button class="btn btn-primary btn-block">Daftar</button>
  </form>
</div>
_END;

echo "</div>"; // penutup tag div container
