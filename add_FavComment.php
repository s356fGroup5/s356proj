<?php
require_once('dbConnect.php');
//importing dbConnect.php script
@$cid = $_GET['comment_id'];
$pid = $_GET['post_id'];
$sql = "SELECT * FROM favoriteComment WHERE user_id =" . $_SESSION['user_id'] . " AND comment_id=" . $cid . ";";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if ($row["user_id"] == $_SESSION['user_id'] && $row["comment_id"] == $cid) {
    echo "<script>alert('Record exist');history.go(-1);</script>";
} else {
    //for testing: echo $_SESSION["user_id"]." & ".$cid." & ".$pid;
    $sql = "INSERT INTO favoriteComment VALUES(NULL," . $_SESSION["user_id"] . "," . $cid . "," . $pid . ");";
    $useless = mysqli_query($con, $sql);
    echo "<script>alert('Added to your list successfully');history.go(-1);</script>";
}

?>
