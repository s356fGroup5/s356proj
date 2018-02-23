<?php include('header.php') ?>
<h1>Create Post</h1><br>
<div class="panel">
    <br>
    <form action="" method=post>

        Title: <input type="text" name="title" size=16 class="form-control"><br>

        Content: <textarea name="content" rows="10" cols="80" class="form-control"></textarea><br>

        <br>
        <input type="submit" value="Submit" class="btn">
    </form>

    <?php
    //importing dbConnect.php script
    require_once('dbConnect.php');
    $user_id = $_SESSION['user_id'];
    $get_userpermit = "SELECT type_id FROM user WHERE user_id = $user_id  ";
    $stat = mysqli_query($con, $get_userpermit);
    $rowst = mysqli_fetch_assoc($stat);
    $userpermit = $rowst['type_id'];

    if ($_SESSION['username'] == "" && $_SESSION['user_id'] == "") {
        header("Location: ./index.php", true, 301);
        exit();

    }
    if ($userpermit == "4") {
        echo "<script>alert('Your account is blocked!! The create post function is not available for you!!');history.go(-1);</script>";
        exit();
    }

    //Getting values
    @$title = $_POST['title'];
    @$content = $_POST['content'];
    $category_id = 1;
    $date = date('Y/m/d');
    $user_id = $_SESSION['user_id'];


    // updating table -- post
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $insert_sql = "INSERT INTO post (title,date,category_id,user_id) VALUES ('$title','$date','$category_id','$user_id');  ";

        if (isset($_SESSION['username'])) {

            $result = mysqli_query($con, $insert_sql);
            @$check = mysqli_fetch_array($result);
        }
        $post_result = $check[0];
        echo $post_result;

        // updating table -- comment
        $get_postid = "SELECT post_id FROM post ORDER BY post_id DESC LIMIT 1";
        $statment = mysqli_query($con, $get_postid);
        $row = mysqli_fetch_assoc($statment);
        $post_id = $row['post_id'];

        $insert_sql2 = "INSERT INTO comment (comment,user_id,date,post_id) VALUES ('$content','$user_id','$date','$post_id')";

        if (isset($_SESSION['username'])) {

            $result2 = mysqli_query($con, $insert_sql2);
            @$check2 = mysqli_fetch_array($result2);
        }
        $post_result2 = $check2[0];
        echo $post_result2;

        //if we got some result
        if ($result) {
            //displaying success
            echo '<div class="alert alert-success"><strong>Success! </strong>Redirect to home page after 3 seconds ...</div>';
            header("refresh:3;url=./index.php");
        } else {
            //displaying failure
            echo '<div class="alert alert-danger"><strong>Error! </strong></div>';
        }
        mysqli_close($con);
    }


    ?>

</div>
<?php include('footer.php') ?>
