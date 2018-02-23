<html>
<head>
    <title>Delete</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<?php
//importing dbConnect.php script
require_once('dbConnect.php');

if ($_SESSION['username'] == "" && $_SESSION['user_id'] == "") {
    header("Location: ./index.php", true, 301);
    exit();

} else {
    //Getting values
    @$pid = $_GET['postid'];
    $sql = "DELETE FROM favoritelist WHERE post_id=" . $pid . " AND user_id =" . $_SESSION['user_id'] . ";";
    mysqli_query($con, $sql);
    echo "<script>alert('Successfully deleted!!');history.go(-1);</script>";

}

?>

</body>
</html>