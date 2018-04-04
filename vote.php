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
    echo 'Please login for voting the topic.';
    header("Location: ./login.php", true, 301);
    exit();
}
//Getting values
@$vote = $_POST['vote'];//get poll_id
@$pid = $_POST['postid'];
$date = date('Y/m/d');
$user_id = $_SESSION['user_id'];

// updating table -- post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $insert_sql = "INSERT INTO poll_record (`poll_id`, `user_id`, category_id, date, post_id) VALUES ('$vote','$user_id', 2,'$date', '$pid')";
    $update_sql = "UPDATE poll SET poll_count = poll_count + 1 WHERE poll_id = '$vote'";
    $result = mysqli_query($con, $insert_sql);
//    $row = mysqli_fetch_array($result);
    $result2 = mysqli_query($con, $update_sql);
//    $row2 = mysqli_fetch_array($result2);
    echo "<script>alert('The vote is submitted successfully.');history.go(-1);</script>";
}

?>
</body>
</html>