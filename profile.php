<?php
require_once 'header.php';
echo "<div class='container'>";
if (!$loggedin) die("<div class='text-center'><h1>Kamu tidak dapat mengakses halaman ini!</h1></div>");

echo "<h3>Profil Kamu</h3>";

$result = query_my_sql("SELECT * FROM profiles WHERE user='$user'");

if (isset($_POST['textphoto'])) {
    $text = sanitize_string($_POST['textphoto']);
    $text = preg_replace('/\s\s+/', ' ', $text);

    if ($result->num_rows)
        query_my_sql("UPDATE profiles SET textphoto ='$text' WHERE user='$user'");

    else query_my_sql("INSERT INTO profiles VALUES('$user', '$text')");
} else {
    if ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $text = stripslashes($row['textphoto']);
    } else $text = "";
}

$text = stripslashes(preg_replace('/\s\s+/', ' ', $text));

if (isset($_FILES['image']['name'])) {
    $saveto = "assets/images/". "$user.jpg";
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

        $max = 100;
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

show_profile("assets/images/".$user);

echo <<<_END
<form method='post' action='profile.php' enctype='multipart/form-data'>
<h3>Masukkan atau sunting profil kamu dan gambar unggah gambar profil</h3>
<textarea name="textphoto">$text</textarea> <br>
Gambar: <input type="file" name="image" size="14">
<button class="btn btn-primary">Simpan Profil</button>
</form>
_END;

echo "</div>"; // penutup tag div container
