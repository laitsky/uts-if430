<?php
require_once 'header.php';

echo "<div class='container'>";
if (!$loggedin) die("<div class='text-center'><h1>Kamu tidak dapat mengakses halaman ini!</h1></div>");

  $user = $_SESSION['user'];
  $result = mysqli_fetch_assoc(query_my_sql("SELECT * FROM members WHERE user='$user'"));

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
    gender = '$gender'");
  }
?>

<div class="editProfile">
    <form action="editProfile.php" method="post">
    <div class="form-group">
    <label for="user">Username</label>
    <input type="hidden" class="form-control" name="user" value="<?php echo $result['user']; ?>">
    <input type="text" class="form-control" name="user" value="<?php echo $result['user']; ?>"disabled>
    </div>
    <div class="form-group">
    <label for="image" >Foto Profil</label><br>
    <?php show_profile("assets/images/".$user); ?>
    <textarea name="textphoto"><?php echo $text ?></textarea><br>
    <input type="file" name="image" size="14">
    </div>
    <div class="form-group">
    <label for="first_name" >Nama Depan</label>
    <input type="text" class="form-control" name="first_name" value="<?php echo $result['first_name']; ?>" maxlength="20">
    </div>
    <div class="form-group">
    <label for="last_name">Nama Belakang (opsional)</label>
    <input type="text" class="form-control" name="last_name" value="<?php echo $result['last_name']; ?>" maxlength="20">
    </div>
    <div class="form-group">
    <label for="birth_date">Tanggal Lahir</label>
    <input type="date" class="form-control" name="birth_date" value="<?php echo $result['birth_date']; ?>">
    </div>
    <div class="form-group">
    <label for="gender">Jenis Kelamin</label>
    <select name="gender" class="custom-select" >
    <option selected  value="<?php echo $result['gender']; ?>"><?php if($result['gender'] == "P"){echo "Perempuan";}else {echo "Laki-laki";} ?></option>
    <option value="L">Laki-laki</option>
    <option value="P">Perempuan</option>
    </select>
    </div>
    <button class="btn btn-primary btn-block" name="update_profile">Update Profile</button>
    </form>
</div>

<?php
echo "</div>"; // penutup tag div container
?>
