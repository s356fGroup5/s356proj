<?php include('header.php'); ?>
    <h1>Register</h1><br>
    <div class="panel">
        <br>
        <?php
        //importing dbConnect.php script
        require_once('dbConnect.php');

        //redirect to user profile if login successfully
        if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
            echo '<div class="alert alert-success"><strong>Success! </strong>Redirect to profile page after 3 seconds ...</div>';
            header("refresh:3;url=./profile.php");


        } else {


            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                //Getting values
                $username = $_POST['username'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                $email = $_POST['email'];
                $reg_date = date('Y/m/d');


                //Check username whether existed or not
                $select_sql = "SELECT * FROM user WHERE username='$username'";
                $select_email_sql = "SELECT * FROM user WHERE email='$email'";
                //Register account
                $insert_sql = "INSERT INTO user (username,password,reg_date,email) VALUES ('$username','$password','$reg_date','$email')  ";

                //Result
                $select_result = mysqli_query($con, $select_sql);
                $select_check = mysqli_fetch_array($select_result);

                $select_email_result = mysqli_query($con, $select_email_sql);
                $select_email_check = mysqli_fetch_assoc($select_email_result);
                $email_check = $select_email_check["email"];

                if (!$select_check && strpos($email, '@') == true) {
                    $result = mysqli_query($con, $insert_sql);
                    $check = mysqli_fetch_array($result);
                } else {
                    $result = "";

                }


                //if we got some result
                if ($result) {
                    //displaying success

                    echo '<div class="alert alert-success"><strong>Success! </strong>Now redirect to Login page</div>';
                    header("refresh:5;url=./login.php");
                    // header("Location: ./login.php", true, 301);
                }

                if ($select_check)
                    echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error! </strong>Username is existed!</div>';
                if (empty($username)) {
                    //displaying failure
                    echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error! </strong>Username cannot empty!</div>';
                }

                function test_input($data)
                {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                if (empty($email)) {
                    echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error! </strong>Email address cannot empty!</div>';
                } else {
                    $email = test_input($email);
                    // check if e-mail address is well-formed
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error! </strong>Invalid email address format!</div>';
                    }
                }

                if (!empty($email_check)) {
                    echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error! </strong>Email address is registered!</div>';
                }

            }
            mysqli_close($con);
        }

        ?>
        <form action="" method=post>
            Username: <input type="text" name="username" size=16 class="form-control"><br>
            Password: <input type="password" name="password" size=16 class="form-control"><br>
            Confirm Password: <input type="password" name="confirm_password" size=16 class="form-control"><br>
            Email: <input type="text" name="email" size=80 class="form-control"><br>
            <br>
            <input type="submit" value="Submit" class="btn">
        </form>
    </div>
<?php include('footer.php'); ?>