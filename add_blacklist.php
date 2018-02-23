<?php
require_once('dbConnect.php');
//importing dbConnect.php script
@$blacklist = $_GET['blacklist'];
$sql = "SELECT * FROM blacklist WHERE user_id =" . $_SESSION['user_id'] . " AND blacklist_user_id=" . $blacklist . ";";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if ($row["user_id"] == $_SESSION['user_id'] && $row["blacklist_user_id"] == $blacklist) {
    echo "<script>alert('Record exist');history.go(-1);</script>";
} else {
    $sql = "INSERT INTO blacklist VALUES(NULL," . $_SESSION["user_id"] . "," . $blacklist . ");";
    $useless = mysqli_query($con, $sql);
    echo "<script>alert('Added to blacklist successfully');history.go(-1);</script>";
}

?>
