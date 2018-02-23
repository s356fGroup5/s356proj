<html>
<head>
    <title>Admin Homepage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Admin Homepage</h1><br>
    <div class="panel">

        <br>
        <?php
        //importing dbConnect.php script
        require_once('dbConnect.php');
        $admin_sql = 'SELECT ut.permission FROM user u, user_type ut WHERE u.type_id = ut.type_id AND u.user_id =' . $_SESSION['user_id'] . '';
        $admin_result = mysqli_query($con, $admin_sql);
        $admin_row = mysqli_fetch_row($admin_result);
        $admin_check = $admin_row[0];

        if ($admin_check >= 255) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                //Getting values
                $choose = $_POST['choose'];
                $user_id = $_POST['user_id'];
                $usertype = $_POST['usertype'];
                $email = $_POST['email'];


                //Creating sql query
                $sql = "UPDATE user SET email = '$email', type_id= '$usertype' WHERE user_id = $user_id";

                //executing query
                $result = mysqli_query($con, $sql);


                //if we got some result
                if ($result == true) {
                    echo '<div class="alert alert-success"><strong>Success! </strong></div>';
                    header("refresh:3;url=./admin.php?action=manageuser");
                } else {

                    echo '<div class="alert alert-danger"><strong>Error! </strong></div>';
                    header("refresh:3;url=./admin.php?action=manageuser");
                }


            }

        }
        mysqli_close($con);

        ?>
    </div>
</div>
</body>
</html>