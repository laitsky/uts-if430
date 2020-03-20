<?php
if(isset($_POST['submit'])){
    session_start();
        $id = mysqli_real_escape_string($conn,$_POST['Post_id']);
        $komentar = mysqli_real_escape_string($conn,$_POST['komentar']);
        $time = date('Y-m-d H:i:s');
        $commenter = $_SESSION['user'];

        $insert_sql_komen = "INSERT INTO comment (post_id, commenter, description, time) VALUES ('$id', '$commenter', '$komentar', '$time')"

        mysqli_query($conn,$insert_sql_komen);
        
        header("location: messages.php");
}
?>