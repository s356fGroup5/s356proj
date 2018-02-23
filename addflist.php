<?php
//add to my favorites list
session_start();
if ($_SESSION['username'] == "" && $_SESSION['user_id'] == "") {
    echo "<script>alert('Plz,Login first');</script>";
    exit();

}
@$pid = $_POST["postid"];
if (!empty($_POST["addflist"])) {
    if ($pid == '' || $_SESSION['user_id'] == '') {
        echo "<script>alert('Error,missing value');</script>";
        exit;
    } else {
        require_once('dbConnect.php');

        $sql = "SELECT * FROM `favoritelist` WHERE post_id =" . $pid . " AND post_id=" . $pid . ";";

        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($row["user_id"] == '' && $row["post_id"] == '') {
            $sql2 = "INSERT INTO `ouhks356_db`.`favoritelist` (`id`, `user_id`, `post_id`) VALUES (NULL," . "'" . $_SESSION['user_id'] . "'" . ",'" . $pid . "');";
            $result2 = mysqli_query($con, $sql2);
            echo "<script>alert('Added to your list successfully');</script>";

        } else if ($row["user_id"] == $_SESSION['user_id'] && $row["post_id"] == $pid) {
            echo "<script>alert('Record exist');</script>";

        }
    }
}
?>
  


