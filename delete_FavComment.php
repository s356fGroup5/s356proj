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
    @$cid = $_GET['comment'];
    $sql = "DELETE FROM favoriteComment WHERE user_id=" . $_SESSION['user_id'] . " AND comment_id=" . $cid . ";";
    mysqli_query($con, $sql);
    echo "<script>alert('Successfully deleted!!')" . header('Location: ./myComment.php') . "</script>";
}

?>

</body>
</html>