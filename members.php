<?php
require_once 'header.php';
echo "<div class='container'>";
if (!$loggedin) die("<div class='text-center'><h1>Kamu tidak dapat mengakses halaman ini!</h1></div>");

if (isset($_GET['view'])) {
    $view = sanitize_string($_GET['view']);
    if ($view == $user) $name = "Kamu";
    else $name = "$view's";

    $result = mysqli_fetch_assoc(query_my_sql("SELECT * FROM members WHERE user='$view'"));


    echo "<div class='center'>";
    echo "<h3>Profil $name</h3>";
    show_profile($view);
    echo "<h5 align='center'>". $result['first_name'] . " " . $result['last_name'] . "</h5>";
    echo "<h6 align='center'><i class='las la-user'></i>". $result['user']. "</h6>";
    echo "<h6 align='center'><i class='las la-birthday-cake'></i>". $result['birth_date']. "</h6>";
    echo "</div>";
    echo "<a href='messages.php?view=$view' class='btn btn-primary btn-block'>Lihat pesan</a>";
}

if (isset($_GET['add'])) {
    $add = sanitize_string($_GET['add']);

    $result = query_my_sql("SELECT * FROM friends WHERE user='$add' AND friend='$user'");
    if (!$result->num_rows)
        query_my_sql("INSERT INTO friends VALUES('$add', '$user')");
} elseif (isset($_GET['remove'])) {
    $remove = sanitize_string($_GET['remove']);
    query_my_sql("DELETE FROM friends WHERE user='$remove' AND friend='$user'");
}

$result = query_my_sql("SELECT user FROM members ORDER BY user");
$num = $result->num_rows;

echo "<h3>Anggota lainnya</h3><ul>";
for ($i = 0; $i < $num; ++$i) {
    echo "<div class='card py-3 my-3'>";
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['user'] == $user) continue;

    echo "<li><a  href='members.php?view=" . $row['user'] . "'>" . $row['user'] . "</a>";
    $follow = "follow";

    $result1 = query_my_sql("SELECT * FROM friends WHERE user='" . $row['user'] . "' AND friend='$user'");
    $t1 = $result1->num_rows;
    $result1 = query_my_sql("SELECT * FROM friends WHERE user='$user' AND friend='" . $row['user'] . "'");
    $t2 = $result1->num_rows;

    if (($t1 + $t2) > 1) echo " &harr; kamu saling mengikuti";
    elseif ($t1) echo " &larr; kamu mengikuti";
    elseif ($t2) {
        echo " &rarr; kamu diikuti";
        $follow = "recip";
    }

    if (!$t1) echo " [<a href='members.php?add=" . $row['user'] . "'>$follow</a>]";
    else      echo " [<a href='members.php?remove=" . $row['user'] . "'>drop</a>]";

    echo "</div>";
}

echo "</ul>";

echo "</div>"; // penutup tag div container
?>
