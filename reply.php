<html>
<head>
    <title>Reply</title>
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
    echo 'Please login in for replying the topic.';
    header("Location: ./login.php", true, 301);
    exit();
}
//Getting values
@$reply = $_POST['reply'];
@$pid = $_POST['postid'];
$date = date('Y/m/d');
$user_id = $_SESSION['user_id'];

// updating table -- post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $insert_sql = "INSERT INTO comment (comment,user_id,date,post_id) VALUES ('$reply','$user_id','$date','$pid')";
    $result = mysqli_query($con, $insert_sql);
    $row = mysqli_fetch_array($result);
    echo "<script>alert('The reply is successful uploaded.');history.go(-1);</script>";
}

?>
</body>
</html>