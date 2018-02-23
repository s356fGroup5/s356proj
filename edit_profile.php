<?php include('header.php'); ?>
<h1>Edit profile</h1><br>
<div class="panel">
    <br>
    <?php
    //importing dbConnect.php script
    require_once('dbConnect.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        //Getting values
        $username = $_SESSION['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $email = $_POST['email'];

        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if (!empty($_POST["password"]) && strcmp($password, $confirm_password) == 0) {
            if (empty($_POST["email"])) {
                echo '<div class="alert alert-danger"><strong>Empty email</div>';
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email = test_input($_POST["email"]);
                echo '<div class="alert alert-danger"><strong>Invalid email</div>';

            } else {

                //UPDATE account
                $update_sql = "UPDATE user set password= '$password', email= '$email' WHERE username ='$username'";

                //update sql commend
                $update_result = mysqli_query($con, $update_sql);


                //if we got some result
                if ($update_result) {
                    //displaying success

                    echo '<div class="alert alert-success"><strong>Success! </strong>Now redirect to profile page</div>';
                    header("refresh:5;url=./profile.php");
                }
            }
        } else {
            echo '<div class="alert alert-danger"><strong>Invalid password</div>';
        }
        mysqli_close($con);
    }
    ?>
    <form action="" method=post>
        New Password: <input type="password" name="password" size=16 class="form-control"><br>
        Confirm New Password: <input type="password" name="confirm_password" size=16 class="form-control"><br>
        New Email: <input type="text" name="email" size=80 class="form-control"><br>
        <br>
        <input type="submit" value="Submit" class="btn">
    </form>
</div>
<?php include('footer.php'); ?>  