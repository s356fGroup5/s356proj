<?php include('header.php'); ?>
    <h1>Login</h1><br>
    <div class="panel">

        <br>

        <div class="row">
            <div class="col-sm-3">
                <input type="button" onclick="loginAs('admin')" value="admin">
            </div>
            <div class="col-sm-6">

                <?php
                //importing dbConnect.php script
                require_once('dbConnect.php');

                //redirect to user profile if already logged-in
                if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
                    echo '<div class="alert alert-success"><strong>Success! </strong>Redirect to home page after 3 seconds ...</div>';
                    header("refresh:0;url=./index.php");
//                    header("refresh:3;url=./index.php");


                } else {


                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        //Getting values
                        $username = $_POST['username'];
                        $password = $_POST['password'];


                        //Creating sql query
                        $sql = "SELECT u.user_id, ut.permission FROM user u, user_type ut WHERE u.type_id = ut.type_id AND u.username='$username' AND u.password='$password'";

                        //importing dbConnect.php script
                        require_once('dbConnect.php');

                        //executing query
                        $result = mysqli_query($con, $sql);

                        //fetching result
                        $check = mysqli_fetch_assoc($result);
                        $user_id = $check['user_id'];
                        $permission = $check['permission'];


                        //if we got some result
                        if ($user_id != "") {
                            echo '<div class="alert alert-success"><strong>Success! </strong>Successful login</div>';
                            $_SESSION['username'] = $username;
                            $_SESSION['user_id'] = $user_id;
                            $_SESSION['permission'] = $permission;
                            //header("Location: ./profile.php", true, 301);
                            header("refresh:3;url=./index.php");
                        } else {

                            echo '<div class="alert alert-danger"><strong>Error! </strong>Username or password incorrect! </div>';
                        }
                    }
                    echo '<form action="" method=post>
Username: <input type="text" name="username" id="username" size=30 class="form-control"><br>
Password: <input type="password" name="password" size=27 class="form-control"><br>
<br>
<input type="submit" value="Submit" class="btn">
</form>';
                    echo '<a href="./forgotpwd.php">Forgot Password?</a>
';

                    mysqli_close($con);
                }

                function loginAs($user){
                    echo '<script type="text/javascript">' . 'document.getElementById("username").value = ' . $user . ';' . '</script>';
//                    echo '<script type="text/javascript">' . 'document.getElementById("password").value = ' . $user . ';' . '</script>';
                }
                ?>


            </div>
            <div class="col-sm-3"></div>
        </div>


    </div>
<?php include('footer.php'); ?>