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

    $pid = $_GET['postid'];
    echo $pid;
    $sql_2 = "SELECT count(*) AS Count FROM comment c, post p WHERE c.post_id = p.post_id AND  p.post_id=$pid GROUP BY c.post_id";
    $delete_post_result = mysqli_query($con, $sql_2);
    $delete_post_row = mysqli_fetch_assoc($delete_post_result);
    $comment_count = $delete_post_row['Count'];
    echo $comment_count;
    if ($comment_count > 1) {

        @$cid = $_GET['comment'];
        $sql = "DELETE FROM favoriteComment WHERE comment_id=$cid ;";
        mysqli_query($con, $sql);
        $sql = "DELETE FROM comment WHERE comment_id=$cid ;";
        mysqli_query($con, $sql);


        echo "<script>alert('Successfully deleted!!');history.go(-1);</script>";
    } else {
        $sql = "DELETE FROM favoriteComment WHERE comment_id=$cid ;";
        mysqli_query($con, $sql);
        $sql = "DELETE FROM post WHERE post_id=$pid ;";
        mysqli_query($con, $sql);
        echo "<script>alert('Post and comment are successfully deleted!!');history.go(-1);</script>";
    }


}

?>

</body>
</html>