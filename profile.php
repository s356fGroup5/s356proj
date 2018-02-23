<?php include('header.php') ?>
<h1 onclick="window.location.href='./index.php'">Avatar &#x1F636</h1><br>
<!-- Edit the image-->
<div class="panel">
    <?php
    //importing dbConnect.php script
    require_once('dbConnect.php');
    //Getting values
    //    $action = $_GET['action'];
    if ($_GET['userid'] != "") {
        $getUID = $_GET['userid'];
    } else {
        $getUID = $_SESSION['user_id'];
    }


    $user_id = $_SESSION['user_id'];//current user
    if ($getUID == $user_id) {
        //Creating sql query
        $sql = "SELECT * FROM user WHERE user_id=$user_id";
    } else {
        $sql = "SELECT * FROM user WHERE user_id=$getUID";
    }


    //executing query
    $result = mysqli_query($con, $sql);

    //fetching result
    $check = mysqli_fetch_assoc($result);
    $icon = $check['icon'];
    $reg_date = $check['reg_date'];
    $email = $check['email'];

    ?>

    <div class="row">
        <div class="col-sm-3">
            <center>
                <h4>Profile</h4>
                <?php

                if ($getUID != "") {
                echo '<img src="./images/icon/' . $icon . '">';
                $sql2 = "SELECT * FROM user u , user_type ut where u.type_id = ut.type_id AND user_id =" . $getUID;
                $result2 = mysqli_query($con, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                $uName = $row2['username'];

                ?>

                <p>
                <form action="/gen-icon.php">
                    <input class="btn btn-info" type="submit" value="Edit your image">
                </form>
                </p>
            </center>
        </div>

        <div class="col-sm-9">


            <table class="table table-striped">
                <thead>
                <tr>
                    <th colspan=2>Information</th>
                </tr>
                </thead>
                <?php
                if ($getUID == $user_id) {
                    echo '<tr><td>Welcome! </td><td>' . $uName . '</td></tr>'; // look
                    echo '<tr><td>User ID: </td><td>' . $row2['user_id'] . '</td></tr>';
                    echo '<tr><td>User Type: </td><td>' . $row2['type'] . '</td></tr>';
                } else {
                    echo '<tr><td>User ID: </td><td>' . $row2['user_id'] . '</td></tr>';
                    echo '<tr><td>User Name: </td><td>' . $row2["username"] . '</td></tr>';
                    echo '<tr><td>User Type: </td><td>' . $row2['type'] . '</td></tr>';
                }

                echo '<tr><td>Register date: </td><td>' . $reg_date . '</td></tr>';
                echo '<tr><td>Email: </td><td>' . $email . '</td></tr>';
                echo '</table>';
                echo '</div>';
                }
                else {
                    echo "Please go to the first page to click the login to login your account!";
                    header("Location: ./index.php", true, 301);
                    exit();
                }
                ?>

                <?php
                // if not its owner no button to click
                if ($getUID == $user_id) {
                    ?>
                    <!-- Edit profile link-->
                    <form action="/edit_profile.php">
                        <input class="btn btn-info" type="submit" value="Edit your information">
                    </form>
                    <?php
                } else {
                    echo '<br/>';
                    echo '<a class="btn btn-danger" href="./report.php?type=3&userid=' . $getUID . '&username=' . $uName . '">Report User</a>';
                    echo ' <a class="btn btn-danger" href="./add_blacklist.php?blacklist=' . $row2['user_id'] . '">Add this user to Blacklist!</a>';
                }
                ?>
        </div>

    </div>
    <?php include('footer.php') ?>
