<?php
require_once 'header.php';

echo "<div class='container'>";
if (!$loggedin) die("<div class='text-center'><h1>Kamu tidak dapat mengakses halaman ini!</h1></div>");

  $valid;
  $user = $_SESSION['user'];
  $result = mysqli_fetch_assoc(query_my_sql("SELECT * FROM members WHERE user='$user'"));
  $results = query_my_sql("SELECT * FROM profiles WHERE user='$user'");  

  if(isset($_POST['update_profile'])){
    $user = sanitize_string($_POST['user']);
    $first_name = sanitize_string($_POST['first_name']);
    $last_name = sanitize_string($_POST['last_name']);
    $birth_date = sanitize_string($_POST['birth_date']);
    $gender = sanitize_string($_POST['gender']);  
    
    query_my_sql("UPDATE members SET
    first_name = '$first_name',
    last_name = '$last_name',
    birth_date = '$birth_date',
    gender = '$gender'
    WHERE user = '$user'");
    $valid = true;

    if (isset($_POST['textphoto'])) {
        $text = sanitize_string($_POST['textphoto']);
        $text = preg_replace('/\s\s+/', ' ', $text);

        if ($results->num_rows)
            query_my_sql("UPDATE profiles SET textphoto ='$text' WHERE user='$user'");
        else query_my_sql("INSERT INTO profiles VALUES('$user', '$text')");
    } else {
        if ($results->num_rows) {
            $row = $results->fetch_array(MYSQLI_ASSOC);
            $text = stripslashes($row['textphoto']);
        } else $text = "";
    }

    $text = stripslashes(preg_replace('/\s\s+/', ' ', $text));

    if (isset($_FILES['image']['name'])) {
        $saveto = "$user.jpg";
        move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
        $typeok = TRUE;


        switch ($_FILES['image']['type']) {
            case "image/gif":
                $src = imagecreatefromgif($saveto);
                break;
            case "image/jpeg":  // Both regular and progressive jpegs
            case "image/pjpeg":
                $src = imagecreatefromjpeg($saveto);
                break;
            case "image/png":
                $src = imagecreatefrompng($saveto);
                break;
            default:
                $typeok = FALSE;
                break;
        }

        if ($typeok) {
            list($w, $h) = getimagesize($saveto);

            $max = 150;
            $tw = $w;
            $th = $h;

            if ($w > $h && $max < $w) {
                $th = $max / $w * $h;
                $tw = $max;
            } elseif ($h > $w && $max < $h) {
                $tw = $max / $h * $w;
                $th = $max;
            } elseif ($max < $w) {
                $tw = $th = $max;
            }
            $tmp = imagecreatetruecolor($tw, $th);
            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
            imageconvolution($tmp, array(array(-1, -1, -1),
                array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
            imagejpeg($tmp, $saveto);
            imagedestroy($tmp);
            imagedestroy($src);
        }
    }
  }
?>
<br>
<h1 style="text-align: center">Edit Profile</h1><hr>
    <?php if(isset($valid)&&$valid){ ?>
    <div class="alert alert-primary" role="alert">Profile telah berhasil diperbarui !</div>
    <?php } ?>
    <form action="editProfile.php" method="post" enctype="multipart/form-data">
        <div class="form-group col-sm-6" style="margin: auto; padding-bottom: 15px">
            <label for="image" >Foto Profil</label><br>
            <?php show_profile($user); ?>
            <h6>Upload different photo</h6>
            <textarea name="textphoto"></textarea><br>
            <input type="file" name="image" size="14">
        </div>
        <div class="form-group col-sm-6" style="margin: auto; padding-bottom: 15px">
            <label for="user">Username</label>
            <input type="hidden" class="form-control" name="user" value="<?php echo $result['user']; ?>">
            <input type="text" class="form-control" name="user" value="<?php echo $result['user']; ?>"disabled>
        </div>
        <div class="form-group col-sm-6" style="margin: auto; padding-bottom: 15px">
            <label for="first_name" >Nama Depan</label>
            <input type="text" class="form-control" name="first_name" value="<?php echo $result['first_name']; ?>" maxlength="20">
        </div>
        <div class="form-group col-sm-6" style="margin: auto; padding-bottom: 15px">
            <label for="last_name">Nama Belakang (opsional)</label>
            <input type="text" class="form-control" name="last_name" value="<?php echo $result['last_name']; ?>" maxlength="20">
        </div>
        <div class="form-group col-sm-6" style="margin: auto; padding-bottom: 15px">
            <label for="birth_date">Tanggal Lahir</label>
            <input type="date" class="form-control" name="birth_date" value="<?php echo $result['birth_date']; ?>">
        </div>
        <div class="form-group col-sm-6" style="margin: auto; padding-bottom: 15px">
            <label for="gender">Jenis Kelamin</label>
            <select name="gender" class="custom-select" >
            <option selected  value="<?php echo $result['gender']; ?>"><?php if($result['gender'] == "P"){echo "Perempuan";}else {echo "Laki-laki";} ?></option>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
            </select>
        </div>
        <div class="col-sm-6" style="margin: auto; padding-top: 8px">
            <button class="btn btn-primary btn-block" name="update_profile">Update Profile</button>
            <br><br>
        </div>
    </form> 

<?php
echo "</div>"; // penutup tag div container
?>
