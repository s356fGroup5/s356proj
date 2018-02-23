<html>
<head>
    <title>Portal</title>
</head>
<body>
Portal<br>


<?php
//importing dbConnect.php script
require_once('dbConnect.php');


//Getting values
$action = $_GET['action'];


if ($action == "logout") {
    unset($_SESSION['username']);
    unset($_SESSION['user_id']);
    echo "Logout successfully!";
    header("Location: ./login.php", true, 301);
    exit();
}


if (isset($_SESSION['username'])) {
    echo 'Hello World! <br>' . $_SESSION['username'] . $_SESSION['user_id'] . '<br>';
    echo '<a href="?action=logout">Logout</a>';
} else {
    echo "Please login your account!";
}


?>
</body>
</html>