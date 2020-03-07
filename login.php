<?php
require_once 'header.php';
$error = $user = $pass = "";

if (isset($_POST['user']))
{
    $user = sanitize_string($_POST['user']);
    $pass = sanitize_string($_POST['pass']);

    if ($user == "" || $pass == "")
        $error = 'Not all fields were entered';
    else
    {
        $result = query_my_sql("SELECT user,pass FROM members WHERE user='$user' AND pass='$pass'");

        if ($result->num_rows == 0)
        {
            $error = "Invalid login attempt";
        }
        else
        {
            $_SESSION['user'] = $user;
            $_SESSION['pass'] = $pass;
            die("<div class='text-center'>You are now logged in. Please
             <a href='members.php?view=$user'>click here</a>
             to continue.</div>");
        }
    }
}

echo <<<_END
<form method='post' action='login.php'>
<div class="form-group">
<span>$error</span>
</div>
<div class="form-group">
<label for="user">Username</label>
<input type="text" name="user" value="$user">
</div>
<div class="form-group">
<label for="pass">Password</label>
<input type="text" name="pass" value="$pass">
</div>
<button class="btn btn-primary">Login</button>
</form>
_END;
