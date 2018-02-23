<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<link rel="stylesheet"
      href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>
<script type="text/javascript"
        src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
</head>
<div class="container">
    <div class="row">
        <?php
        require_once('dbConnect.php');
        session_start();


        @$content = $_POST['content'];
        $reporter = $_SESSION['user_id'];
        $comment = $_GET['comment'];
        $uid = $_GET['userid'];
        $name = $_GET['username'];
        $title = $_GET['title'];
        $pid = $_GET['postid'];
        $cid = $_GET['commentid'];
        $date = date('Y/m/d');
        $type = $_GET['type'];

        if ($_SESSION['username'] == "" && $_SESSION['user_id'] == "") {
            echo '<div class="alert alert-danger"><strong>Error, Plz,Login first </strong></div>';
        } else {

            if ($type == 1) //type 1 report post
            {
                echo '<ul class="list-group" style="margin-top: 20px">';
                echo '<li class="list-group-item">Report the User: ' . $name . '</li>';
                echo '<li class="list-group-item">Post Title: ' . $title . '</li>';
                echo '</ul>';
                echo '<form action="" method=post>';
                echo 'Reason: <textarea name="content" rows="10" cols="80" class="form-control"></textarea><br><br>';
                echo '<input type="submit" value="Submit" class="btn">';
                echo '</form>';
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if ($uid == '' || $pid == '' || $type == '' || $reporter == '' || $content == '')
                        echo "<script>alert('Error, missing some value');</script>";
                    else {
                        $sql = "INSERT INTO reportlist (type,reporter_id,user_id,post_id,reason,date) VALUES ('$type','$reporter','$uid','$pid','$content','$date')";
                        $result = mysqli_query($con, $sql);
                        echo "<script>alert('Report successfully');</script>";
                        echo "<script>history.go(-2);</script>";
                    }
                }


            } else if ($type == 2) //type 2 report comment
            {
                echo '<ul class="list-group" style="margin-top: 20px">';
                echo '<li class="list-group-item">Report the User: ' . $name . '</li>';
                echo '<li class="list-group-item">Post Title: ' . $title . '</li>';
                echo '<li class="list-group-item">Comment: ' . $comment . '</li>';
                echo '</ul>';
                echo '<form action="" method=post>';
                echo 'Reason: <textarea name="content" rows="10" cols="80" class="form-control"></textarea><br><br>';
                echo '<input type="submit" value="Submit" class="btn">';
                echo '</form>';
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if ($uid == '' || $pid == '' || $type == '' || $reporter == '' || $cid == '' || $content == '')
                        echo "<script>alert('Error, missing some value');</script>";
                    else {
                        $sql = "INSERT INTO reportlist (type,reporter_id,user_id,post_id,comment_id,reason,date) VALUES ('$type','$reporter','$uid','$pid','$cid','$content','$date')";
                        $result = mysqli_query($con, $sql);
                        echo "<script>alert('Report successfully');</script>";
                        echo "<script>history.go(-2);</script>";
                    }
                }

            } else if ($type == 3) //type 3 report user
            {
                echo '<ul class="list-group" style="margin-top: 20px">';
                echo '<li class="list-group-item">Report the User: ' . $name . '</li>';
                echo '</ul>';
                echo '<form action="" method=post>';
                echo 'Reason: <textarea name="content" rows="10" cols="80" class="form-control"></textarea><br><br>';
                echo '<input type="submit" value="Submit" class="btn">';
                echo '</form>';
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if ($uid == '' || $content == '')
                        echo "<script>alert('Error, missing some value');</script>";
                    else {
                        $sql = "INSERT INTO reportlist (type,reporter_id,user_id,reason,date) VALUES ('$type','$reporter','$uid','$content','$date')";
                        $result = mysqli_query($con, $sql);
                        echo "<script>alert('Report successfully');</script>";
                        echo "<script>history.go(-2);</script>";
                    }
                }
            } else {
                echo '<div class="alert alert-danger"><strong>Error, missing some value </strong></div>';
            }
        }
        ?>



