<?php
require_once 'header.php';
echo "<div class='container'>";
if (!$loggedin) die("<div class='text-center'><h1>Kamu tidak dapat mengakses halaman ini!</h1></div>");
$result = query_my_sql("SELECT user FROM members ORDER BY user");
$num = $result->num_rows;

for ($i = 0; $i < $num; ++$i) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['user'] == $user) continue;



    $result1 = query_my_sql("SELECT * FROM friends WHERE user='" . $row['user'] . "' AND friend='$user'");
    $t1 = $result1->num_rows;
    $result1 = query_my_sql("SELECT * FROM friends WHERE user='$user' AND friend='" . $row['user'] . "'");
    $t2 = $result1->num_rows;

    if (($t1 + $t2) > 1) {
        echo "<li><a  href='members.php?view=" . $row['user'] . "'>" . $row['user'] . "</a>";
        echo " &harr; kamu berteman";
        echo "<br>";
    }
}

echo "</div>"; // penutup tag div container
