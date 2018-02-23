<?php require_once('dbConnect.php'); ?>
<html>
<head>
    <meta name="generator"
          content="HTML Tidy for HTML5 (experimental) for Windows https://github.com/w3c/tidy-html5/tree/c63cc39"/>
    <title>Admin Homepage</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Admin Homepage</h1>
    <br/>

    <nav class="navbar navbar-default">
        <div class="container-fluid">

            <ul class="nav navbar-nav">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-user"></span> Welcome
                        Admin <?php echo $_SESSION['username']; ?> !</a>
                </div>

                <li><a href="./index.php">Homepage</a></li>
                <li><a href="./admin.php">Admin Homepage</a></li>
                <li><a href="./profile.php">Profile</a></li>
                <li><a href="./getpost.php">Read Post</a></li>
                <li><a href="./createpost.php">Create Post</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

                <li><a href="./getpost.php?action=logout"><span class="glyphicon glyphicon-log-in"></span> Logout</a>
                </li>
            </ul>
        </div>
    </nav>


    <div class="panel">
        <?php
        //importing dbConnect.php script 


        $admin_sql = 'SELECT ut.permission FROM user u, user_type ut WHERE u.type_id = ut.type_id AND u.user_id =' . $_SESSION['user_id'] . '';
        $admin_result = mysqli_query($con, $admin_sql);
        $admin_row = mysqli_fetch_row($admin_result);
        $admin_check = $admin_row[0];

        if ($admin_check >= 255) {
            ?>


            <ul class="nav nav-tabs">
                <?php
                echo ($_GET['action'] == '') ?
                    '<li class="active"><a href="./admin.php?action">Statistics</a></li>' :
                    '<li class="none"><a href="./admin.php?action">Statistics</a></li>';

                echo ($_GET['action'] == 'managepost') ?
                    '<li class="active"><a href="./admin.php?action=managepost">Post Management</a></li>' :
                    '<li class="none"><a href="./admin.php?action=managepost">Post Management</a></li>';

                echo ($_GET['action'] == 'manageuser' || $_GET['action'] == 'edituser' || $_GET['action'] == 'sendmessage') ?
                    '<li class="active"><a href="?action=manageuser">User Management</a></li>' :
                    '<li class="none"><a href="?action=manageuser">User Management</a></li>';
                echo ($_GET['action'] == 'reportuserlist') ?
                    '<li class="active"><a href="?action=reportuserlist">Report Post List</a></li>' :
                    '<li class="none"><a href="?action=reportuserlist">Report Post List</a></li>';
                echo ($_GET['action'] == 'reportcmlist') ?
                    '<li class="active"><a href="?action=reportcmlist">Report CM List</a></li>' :
                    '<li class="none"><a href="?action=reportcmlist">Report CM List</a></li>';
                ?>
            </ul>

            <?php
            //Creating sql query

            $date = date('Y/m/d');

            $total_post_sql = "SELECT count(*) FROM post ";
            $total_user_sql = "SELECT count(*) FROM user ";
            $today_post_sql = "SELECT count(*) FROM post WHERE date = '$date'";
            $today_user_sql = "SELECT count(*) FROM user WHERE reg_date = '$date'";
            $user_postnum_sql = "SELECT p.user_id , u.username, count(post_id) AS total_post FROM post p, user u WHERE p.user_id = u.user_id GROUP BY p.user_id ORDER BY 3 DESC ";
            $user_createnum_sql = "SELECT * FROM user ORDER BY reg_date DESC ";
            $user_report_sql = "SELECT * FROM reportlist ORDER BY id DESC ";

            //executing query

            $total_post_result = mysqli_query($con, $total_post_sql);
            $total_user_result = mysqli_query($con, $total_user_sql);
            $today_post_result = mysqli_query($con, $today_post_sql);
            $today_user_result = mysqli_query($con, $today_user_sql);
            $user_postnum_result = mysqli_query($con, $user_postnum_sql);
            $user_createnum_result = mysqli_query($con, $user_createnum_sql);
            $user_report_result = mysqli_query($con, $user_report_sql);


            //fetching result
            $total_post_row = mysqli_fetch_row($total_post_result);
            $total_post = $total_post_row[0];

            $total_user_row = mysqli_fetch_row($total_user_result);
            $total_user = $total_user_row[0];

            $today_post_row = mysqli_fetch_row($today_post_result);
            $today_post = $today_post_row[0];

            $today_user_row = mysqli_fetch_row($today_user_result);
            $today_user = $today_user_row[0];


            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $action = $_GET["action"];
                $id = $_GET["id"];


                if ($action == "") {


                    ?>
                    <div class="well well-sm">
                        <div class="row">
                            <div class="col-sm-3">
                                <h4>Total number of post: <?php echo $total_post ?></h4>
                            </div>
                            <div class="col-sm-3">
                                <h4>Total number of user: <?php echo $total_user ?></h4>
                            </div>
                            <div class="col-sm-3">
                                <h4>Today's post: <?php echo $today_post ?></h4>
                            </div>
                            <div class="col-sm-3">
                                <h4>Today's member: <?php echo $today_user ?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <table class="table  table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Total Post (Top 3)</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Username</th>
                                    <th class="text-center">Number of post</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $count = 0;
                                while ($row = mysqli_fetch_assoc($user_postnum_result)) {
                                    $count++;
                                    echo '<tr><td class="text-center">'
                                        . $row["username"] . '</td><td class="text-center">' . $row["total_post"] . '</td></tr>';

                                    if ($count == 3) break;
                                }

                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <table class="table  table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Latest Member List</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Username</th>
                                    <th class="text-center">Registration Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $count = 0;
                                while ($row = mysqli_fetch_assoc($user_createnum_result)) {
                                    $count++;
                                    echo '<tr><td class="text-center">'
                                        . $row["username"] . '</td><td class="text-center">' . $row["reg_date"] . '</td></tr>';

                                    if ($count == 3) break;
                                }

                                ?>
                                </tbody>
                            </table>
                        </div>


                        <div class="col-sm-12">
                            <table class="table  table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Report List</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Report ID</th>
                                    <th class="text-center">Reporter</th>
                                    <th class="text-center">Reported User ID</th>
                                    <th class="text-center">Reported Post ID</th>
                                    <th class="text-center">Reported Comment ID</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Comment</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                while ($row = mysqli_fetch_assoc($user_report_result)) {
                                    $count++;
                                    echo '<tr><td class="text-center">' . $row["id"] . '</td><td class="text-center">'
                                        . $row["reporter_id"] . '</td><td class="text-center">'
                                        . $row["user_id"] . '</td><td class="text-center">'
                                        . $row["post_id"] . '</td><td class="text-center">' . $row["comment_id"] . '</td><td class="text-center">' . $row["date"] . '</td><td class="text-center">' . $row["reason"] . '</td></tr>';


                                }

                                ?>
                                </tbody>
                            </table>

                        </div>


                    </div>
                    <?php


                }

                if ($action == "blockuser") {
                    $block_user_sql = "UPDATE user SET type_id = 4 where user_id ='$id'";
                    $block_user_result = mysqli_query($con, $block_user_sql);
                    echo '<div class="alert alert-success"><strong>Success </strong>Record deleted! Redirect to homepage after 3 seconds ...</div>';
                    header("refresh:3;url=?action=manageuser");

                }

                if ($action == "sendmessage") {

                    $email_sql = "SELECT * FROM user WHERE user_id ='$id'";
                    $email_result = mysqli_query($con, $email_sql);
                    $email_row = mysqli_fetch_assoc($email_result);
                    $email = $email_row["email"];
                    $username = $email_row["username"];
                    $icon = $email_row["icon"];

                    echo '<div class="row">';
                    echo '<div class="col-sm-4">
				   <img src="./images/icon/' . $icon . '"></img></div>';


                    echo '<div class="col-sm-8">';


                    echo '<label>To: ' . $username . '</label>
		 <form action="./admin-message.php" method=post>
		 <input type="hidden" name="to" value="' . $email . '">
		 <label>Subject: </label><input class="form-control" type="text" name="subject">
		 <label>Content: </label><textarea class="form-control" type="text" name="content"></textarea>
		 <input type="hidden" name="username" value="' . $username . '">
		 <br>
		 <input type="submit" value="Submit" class="btn btn-default">
		 
		 </form>';
                    echo '</div></div>';

                }

                if ($action == "deletepost") {
                    $delete_post_sql = "Delete FROM post where post_id ='$id'";
                    $delete_post_result = mysqli_query($con, $delete_post_sql);

                    echo '<div class="alert alert-success"><strong>Success </strong>Record deleted! Redirect to homepage after 3 seconds ...</div>';
                    header("refresh:3;url=?action=managepost");

                }

                if ($action == "manageuser") {

                    $user_sql = "SELECT * FROM user u, user_type ut WHERE u.type_id = ut.type_id ORDER BY u.user_id DESC";
                    $user_result = mysqli_query($con, $user_sql);

                    echo 'Full member list: <br>';
                    echo '<input class="form-control" id="searchUser" type="text" placeholder="Search User..">';
                    echo '<table class="table  table-bordered table-hover" >';
                    echo '<thead><tr><th class="text-center">User ID</th><th  class="text-center">Username</th><th  class="text-center">User type</th><th class="text-center">Registration date</th><th class="text-center">Email address</th><th class="text-center">Action</th></tr></thead>';
                    echo '<tbody id="Listuser">';
                    while ($row = mysqli_fetch_assoc($user_result)) {
                        echo '<tr><td class="text-center">' . $row["user_id"] . '</td><td class="text-center"><a href="./profile.php?userid=' . $row["user_id"] . '">' . $row["username"] . '</a></td><td class="text-center">'
                            . $row["type"] . '</td><td class="text-center">' . $row["reg_date"] . '</td><td class="text-center">' . $row["email"] . '</td><td class="text-center"><a class="btn btn-default btn-sm" href="?action=edituser&id=' . $row["user_id"] . '"><span class="glyphicon glyphicon-pencil"></span> Edit</a>  
           
		   <button type="button" class="btn btn-default btn-sm"  data-id="' . $row["username"] . '" data-toggle="modal" data-href="?action=blockuser&id=' . $row["user_id"] . '" data-target="#confirm-block-user"><span class="glyphicon glyphicon-remove"></span> Block</button>
		   <a class="btn btn-default btn-sm" href="?action=sendmessage&id=' . $row["user_id"] . '"><span class="glyphicon glyphicon-send"></span> Send</a></td></tr>';
                    }
                    echo '</tbody></table>';

                }

//

                if ($action == "deleteposts1") {
                    $delete_post_sql = "Delete FROM post where post_id ='$id'";
                    $delete_post_result = mysqli_query($con, $delete_post_sql);
                    $delete_post_sql = "Delete FROM reportlist where post_id ='$id' AND type = 1";
                    $delete_post_result = mysqli_query($con, $delete_post_sql);

                    echo '<div class="alert alert-success"><strong>Success </strong>Record deleted! Redirect to homepage after 3 seconds ...</div>';
                    header("refresh:3;url=?action=reportuserlist");

                }
                if ($action == "deleterecord1") {
                    $delete_post_sql = "Delete FROM reportlist where post_id ='$id' AND type = 1";
                    $delete_post_result = mysqli_query($con, $delete_post_sql);

                    echo '<div class="alert alert-success"><strong>Success </strong>Record deleted! Redirect to homepage after 3 seconds ...</div>';
                    header("refresh:3;url=?action=reportuserlist");

                }

                //
                if ($action == "reportuserlist") {
                    //
                    $reporter_sql = "SELECT r.id, r.reporter_id, r.user_id, r.date, u.username, r.reason, r.post_id
                FROM reportlist r, user u 
                WHERE r.reporter_id = u.user_id AND r.type = 1
                ORDER BY r.id DESC";
                    $reporter_result = mysqli_query($con, $reporter_sql);
                    //check name of the complainant
                    $rpu_sql = "SELECT r.user_id, u.username 
                FROM reportlist r, user u 
                WHERE r.user_id = u.user_id AND r.type = 1 
                ORDER BY r.id DESC";
                    $rpu_result = mysqli_query($con, $rpu_sql);
                    //check post titile
                    $posts_sql = "SELECT r.id,p.title,p.post_id
                FROM reportlist r, post p 
                WHERE r.post_id = p.post_id AND r.type = 1
                ORDER BY r.id DESC";
                    $posts_result = mysqli_query($con, $posts_sql);

                    echo '<table class="table  table-bordered table-hover" style="margin-top:5px">';
                    echo '<thead><tr><th class="text-center">Post ID</th><th  class="text-center">Complainant</th><th  class="text-center">Reported By</th><th class="text-center">Date Reported</th><th class="text-center">Detail</th><th class="text-center">Action</th></tr></thead>';

                    echo '<tbody id="Listuser">';
                    $num = 10; //read more id
                    while ($rows = mysqli_fetch_assoc($reporter_result)) {
                        $rpu = mysqli_fetch_assoc($rpu_result);
                        $pst = mysqli_fetch_assoc($posts_result);

                        echo '<tr><td class="text-center">' . $rows["post_id"] . '</td><td class="text-center">' . $rpu["username"] . '</td><td class="text-center">'
                            . $rows["username"] . '</td><td class="text-center">' . $rows["date"] . '</td><td class="text-center"><a data-toggle="modal" data-target="#' . $num . '">More Detail</a></td><td class="text-center">  
        <button type="button" class="btn btn-default btn-sm"  data-id="' . $pst["post_id"] . '" data-toggle="modal" data-href="?action=deleterecord1&id=' . $pst["post_id"] . '" data-target="#confirm-delete-post"><span class="glyphicon glyphicon-remove"></span> Delete Record</button>
       <button type="button" class="btn btn-default btn-sm"  data-id="' . $pst["post_id"] . '" data-toggle="modal" data-href="?action=deleteposts1&id=' . $pst["post_id"] . '" data-target="#confirm-delete-post"><span class="glyphicon glyphicon-remove"></span> Delete Post</button>
       </td></tr>';


                        echo ' <div class="modal fade" id="' . $num . '" role="dialog">';
                        echo ' <div class="modal-dialog modal-lg">';
                        echo ' <div class="modal-content">';
                        echo '  <div class="modal-header">';
                        echo '   <button type="button" class="close" data-dismiss="modal">&times;</button>';
                        echo '   <h4 class="modal-title">Report Detail</h4>';
                        echo '  </div>';
                        echo '   <div class="modal-body">';
                        echo '<ul class="list-group" style="margin-top: 20px">';
                        echo '<li class="list-group-item">Report the User: ' . $rows["username"] . '</li>';
                        echo '<li class="list-group-item">Post Title: ' . $pst["title"] . '</li>';
                        echo '<li class="list-group-item">Reason: <br>' . $rows["reason"] . '</li>';
                        echo '</ul>';
                        echo '  </div>';
                        echo '   <div class="modal-footer">';
                        echo '    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                        echo '   </div>';
                        echo '   </div>';
                        echo '  </div>';
                        echo '  </div>';
                        ++$num;
                    }
                    echo '</tbody></table>';

                }

                if ($action == "deletecomment2") {
                    $delete_post_sql = "Delete FROM comment where comment_id ='$id'";
                    $delete_post_result = mysqli_query($con, $delete_post_sql);
                    $delete_post_sql = "Delete FROM reportlist where comment_id ='$id' AND type = 2";
                    $delete_post_result = mysqli_query($con, $delete_post_sql);

                    echo '<div class="alert alert-success"><strong>Success </strong>Record deleted! Redirect to homepage after 3 seconds ...</div>';
                    header("refresh:3;url=?action=reportuserlist");

                }
                if ($action == "deleterecord2") {
                    $delete_post_sql = "Delete FROM reportlist where comment_id ='$id' AND type = 2";
                    $delete_post_result = mysqli_query($con, $delete_post_sql);

                    echo '<div class="alert alert-success"><strong>Success </strong>Record deleted! Redirect to homepage after 3 seconds ...</div>';
                    header("refresh:3;url=?action=reportuserlist");

                }


                if ($action == "reportcmlist") {


                    //
                    $reporter_sql = "SELECT r.id, r.reporter_id, r.user_id, r.date, u.username, r.reason
                FROM reportlist r, user u 
                WHERE r.reporter_id = u.user_id AND r.type = 2
                ORDER BY r.id DESC";
                    $reporter_result = mysqli_query($con, $reporter_sql);
                    //check name of the complainant
                    $rpu_sql = "SELECT r.user_id, u.username 
                FROM reportlist r, user u 
                WHERE r.user_id = u.user_id AND r.type = 2
                ORDER BY r.id DESC";
                    $rpu_result = mysqli_query($con, $rpu_sql);
                    //check post titile
                    $posts_sql = "SELECT r.id,p.title
                FROM reportlist r, post p 
                WHERE r.post_id = p.post_id AND r.type = 2
                ORDER BY r.id DESC";
                    $posts_result = mysqli_query($con, $posts_sql);
                    $cm_sql = "SELECT r.id, c.comment, c.comment_id
                FROM reportlist r, comment c 
                WHERE r.comment_id = c.comment_id AND r.type = 2
                ORDER BY r.id DESC";
                    $cm_result = mysqli_query($con, $cm_sql);

                    echo '<table class="table  table-bordered table-hover" style="margin-top:5px">';
                    echo '<thead><tr><th class="text-center">Comment ID</th><th  class="text-center">Complainant</th><th  class="text-center">Reported By</th><th class="text-center">Date Reported</th><th class="text-center">Detail</th><th class="text-center">Action</th></tr></thead>';

                    echo '<tbody id="Listuser">';
                    $num = 10; //read more id


                    while ($rows = mysqli_fetch_assoc($reporter_result)) {
                        $rpu = mysqli_fetch_assoc($rpu_result);
                        $pst = mysqli_fetch_assoc($posts_result);
                        $cm = mysqli_fetch_assoc($cm_result);


                        echo '<tr><td class="text-center">' . $cm["comment_id"] . '</td><td class="text-center">' . $rpu["username"] . '</td><td class="text-center">'
                            . $rows["username"] . '</td><td class="text-center">' . $rows["date"] . '</td><td class="text-center"><a data-toggle="modal" data-target="#' . $num . '">More Detail</a></td><td class="text-center">  
      <button type="button" class="btn btn-default btn-sm"  data-id="' . $cm["comment_id"] . '" data-toggle="modal" data-href="?action=deleterecord2&id=' . $cm["comment_id"] . '" data-target="#confirm-delete-post"><span class="glyphicon glyphicon-remove"></span> Delete Record</button>
      <button type="button" class="btn btn-default btn-sm"  data-id="' . $cm["comment_id"] . '" data-toggle="modal" data-href="?action=deletecomment2&id=' . $cm["comment_id"] . '" data-target="#confirm-delete-post"><span class="glyphicon glyphicon-remove"></span> Delete Comment</button>
      </td></tr>';


                        echo ' <div class="modal fade" id="' . $num . '" role="dialog">';
                        echo ' <div class="modal-dialog modal-lg">';
                        echo ' <div class="modal-content">';
                        echo '  <div class="modal-header">';
                        echo '   <button type="button" class="close" data-dismiss="modal">&times;</button>';
                        echo '   <h4 class="modal-title">Report Detail</h4>';
                        echo '  </div>';
                        echo '   <div class="modal-body">';
                        echo '<ul class="list-group" style="margin-top: 20px">';
                        echo '<li class="list-group-item">Report the User: ' . $rows["username"] . '</li>';
                        echo '<li class="list-group-item">Post Title: ' . $pst["title"] . '</li>';
                        echo '<li class="list-group-item">Comment:<br> ' . $cm["comment"] . '</li>';
                        echo '<li class="list-group-item">Reason: <br>' . $rows["reason"] . '</li>';
                        echo '</ul>';
                        echo '  </div>';
                        echo '   <div class="modal-footer">';
                        echo '    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                        echo '   </div>';
                        echo '   </div>';
                        echo '  </div>';
                        echo '  </div>';
                        ++$num;
                    }
                    echo '</tbody></table>';

                }

                if ($action == "managepost") {
                    $post_sql = "SELECT * FROM post p, user u, comment c WHERE p.user_id = u.user_id AND p.post_id = c.post_id GROUP BY p.post_id ORDER BY p.post_id DESC";
                    $post_result = mysqli_query($con, $post_sql);
                    echo 'Latest topic: <br>';
                    echo '<input class="form-control" id="searchPost" type="text" placeholder="Search Post..">';
                    echo '<table class="table  table-bordered table-hover" >';
                    echo '<thead><tr><th class="text-center">Post ID</th><th  class="text-center" style="width:50%">Title</th><th class="text-center">User</th><th class="text-center">Date</th><th class="text-center">Action</th></tr></thead>';
                    echo '<tbody id="listPost">';
                    while ($row = mysqli_fetch_assoc($post_result)) {
                        $post_id = $row["post_id"];
                        echo '<tr><td class="text-center">' . $row["post_id"] . '</td><td class="text-center" style="width:50%"><a target="_blank" href="./getpost.php?postid=' . $row["post_id"] . '">'
                            . $row["title"] . '</a></td><td class="text-center"><a href="./profile.php?userid=' . $row["user_id"] . '">' . $row["username"] . '</a></td><td class="text-center">'
                            . $row["date"] . '</td><td class="text-center">' . '<a class="btn btn-default btn-sm" href="./edit.php?comment=' . $row["comment_id"] . '"><span class="glyphicon glyphicon-pencil"></span> Edit</a>  
           
		   <button type="button" class="btn btn-default btn-sm"  data-id="' . $row["post_id"] . '" data-toggle="modal" data-href="?action=deletepost&id=' . $row["post_id"] . '" data-target="#confirm-delete-post"><span class="glyphicon glyphicon-remove"></span> Delete</button>

		   </td></tr>';
                    }
                    echo '</tbody></table>';

                }


                if ($action == "edituser") {
                    $user_edit_sql = "SELECT * FROM user u, user_type ut WHERE u.type_id = ut.type_id AND u.user_id = $id";
                    $user_edit_result = mysqli_query($con, $user_edit_sql);
                    $row = mysqli_fetch_assoc($user_edit_result);

                    $selected_type = $row["type_id"];
                    $email = $row["email"];
                    $icon = $row["icon"];
                    $permission = $admin_check;
                    echo '<div class="row">';
                    echo '<div class="col-sm-4">
				   <img src="./images/icon/' . $icon . '"></img></div>';


                    echo '<div class="col-sm-8">';
                    echo '<form action="./admin-dataprocess.php" method=post>
                        <label>User ID: </label> ' . $id . '<br>
                        <label>User Type: </label>';
                    if ($permission == 256) {
                        echo '<select class="form-control" name="usertype" >';
                        $usertype_list_sql = "SELECT * FROM user_type ut ";
                        $usertype_list_result = mysqli_query($con, $usertype_list_sql);

                        while ($row = mysqli_fetch_assoc($usertype_list_result)) {
                            if ($row["type_id"] == $selected_type) {
                                echo '<option selected = selected value="' . $row["type_id"] . '">' . $row["type"] . '</option>';
                            } else echo '<option value="' . $row["type_id"] . '">' . $row["type"] . '</option>';
                        }

                        echo ' </select>';
                    } else {

                        echo '<select class="form-control" name="usertype" >';
                        $usertype_list_sql = "SELECT * FROM user_type ut ";
                        $usertype_list_result = mysqli_query($con, $usertype_list_sql);

                        while ($row = mysqli_fetch_assoc($usertype_list_result)) {

                            if ($row["type_id"] == $selected_type) {
                                echo '<option selected = selected value="' . $row["type_id"] . '">' . $row["type"] . '</option>';
                            } else {
                                if ($row["type_id"] == 5) continue;
                                echo '<option value="' . $row["type_id"] . '">' . $row["type"] . '</option>';
                            }
                        }

                        echo ' </select>';


                    }

                    echo '<br>';

                    echo '<label>Email address: </label><input type="text" name="email" size=30 class="form-control" value="' . $email . '"><br>
                        <input type="hidden" name="user_id" value="' . $id . '">
                        <input type="submit" value="Submit" class="btn">
                        </form>';

                    echo '</div>';
                    echo '</div>';


                }


            }

            //

            //
        } else {

            echo '<div class="alert alert-danger"><strong>Error! </strong>No Permission! Redirect to homepage after 3 seconds ...</div>';
            header("refresh:3;url=./index.php");
        }
        ?>
        <!-- Modal -->
        <div id="confirm-block-user" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Block User</h4>
                    </div>
                    <div class="modal-body">
                        <p class="data"></p>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-danger btn-ok">Block</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#confirm-block-user').on('show.bs.modal', function (e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
                $id = $(this).find('.btn-ok').attr('id', $(e.relatedTarget).data('id'));
                $('.data').html('Block User <strong>' + $(this).find('.btn-ok').attr('id') + '?</strong>');

            });

        </script>

        <!-- Modal -->
        <div id="confirm-delete-post" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Are you sure to Delete?</h4>
                    </div>
                    <div class="modal-body">
                        <p class="data"></p>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-danger btn-ok">Delete</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#confirm-delete-post').on('show.bs.modal', function (e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
                $id = $(this).find('.btn-ok').attr('id', $(e.relatedTarget).data('id'));
                $('.data').html('Delete Post #<strong>' + $(this).find('.btn-ok').attr('id') + '?</strong>');

            });

        </script>

        <script>
            $(document).ready(function () {
                $("#searchUser").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("#listUser tr").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $("#searchPost").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("#listPost tr").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script>
    </div>
</div>
</body>
</html>
