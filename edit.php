<?php include('header.php'); ?>
    <div class="panel">
        <?php
        //importing dbConnect.php script
        require_once('dbConnect.php');

        if ($_SESSION['username'] == "" && $_SESSION['user_id'] == "") {
            header("Location: ./index.php", true, 301);
            exit();
        } else {

            //Getting values
            @$cid = $_GET['comment'];
            $sql = "SELECT comment FROM comment WHERE comment_id=$cid ;";
            $result = mysqli_query($con, $sql);
            $check = mysqli_fetch_array($result);
            $comm = $check[0];
            $old_comm = $comm;
            echo "The original comment is:" . $comm;
            echo "<br><br> What is you new comment?";
        }
        ?>


        <?php
        // change comment
        @$comm = $_POST['content'];
        @$cid = $_GET['comment'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sql2 = "UPDATE comment SET comment='$comm' WHERE comment_id=$cid;";
            if (isset($_SESSION['username'])) {

                $result2 = mysqli_query($con, $sql2);
                @$check2 = mysqli_fetch_array($result2);
            }
            $edit_result = $check2[0];
            echo $edit_result;

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
        <form action="" method=post>
            comment: <textarea name="content" rows="10" cols="80"
                               class="form-control"><?php echo $old_comm ?></textarea><br>
            <br>
            <input type="submit" value="Submit" class="btn">
        </form>
        <br>
        <button onclick="window.history.back();" align='right'>Go Back</button>
    </div>
<?php include('footer.php'); ?>