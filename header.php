<html>
<head>
    <title>Avatar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="shortcut icon" type="image/png" href="/images/fav.png"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="./index.php">Avatar</a>
        </div>
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    echo '<ul class="nav navbar-nav">';
    echo '<li><a href="./getpost.php">Read Post</a></li>';
    echo ' </ul>';
    echo '<form class="navbar-form navbar-left" method="post" action="./search.php">';
    echo '  <div class="form-group">';
    echo '    <input type="text" class="form-control" placeholder="Quick Search" size="10">';
    echo '  </div>';
    echo '  <button type="submit" name="search" class="btn btn-default">Submit</button>';
    echo '</form>';
    echo '<ul class="nav navbar-nav navbar-right">';
    echo '  <li><a href="./register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>';
    echo '  <li><a href="./login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
    echo '</ul>';
    echo ' </div>';
    echo '</nav> ';
    echo '<div class="container">';
    echo ' <br><br><br>';
} else {
    $permission = $_SESSION['permission'];
    echo '<ul class="nav navbar-nav">';
    echo '<li><a href="./createpost.php">Create Post</a></li>';
    echo '<li><a href="./getpost.php">Read Post</a></li>';
    echo '<li><a href="./favoriteslist.php">My Favorites</a></li>';
    echo '<li><a href="./myOwnComment.php">My Comments</a></li>';
    echo '<li><a href="./myBlacklist.php">My Blacklist</a></li>';
    echo '<li><a href="./profile.php?userid=' . $_SESSION["user_id"] . '">Profile</a></li>';
    echo '<li><a href="./gen-icon.php">Avatar Generator</a></li>';
    echo ' </ul>';
    echo '<form class="navbar-form navbar-left" method="post" action="./search.php">';
    echo '  <div class="form-group">';
    echo '   <input type="text" name="search" class="form-control" placeholder="Quick Search" size="10">';
    echo ' </div>';
    echo '  <button type="submit" class="btn btn-default">Submit</button>';
    echo '  </form>';
    echo ' <ul class="nav navbar-nav navbar-right">';
    if ($permission >= 255) {
        echo '<li><a href="./admin.php">Admin Panel</a></li>';
    }
    echo '   <li><a href="?action=logout"><span class="glyphicon glyphicon-user"></span>Logout</a></li>';
    echo '  </ul>';
    echo ' </div>';
    echo '</nav> ';
    echo '<div class="container">';
    echo ' <br><br><br>';

    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        if ($action == "logout") {
            unset($_SESSION['username']);
            unset($_SESSION['user_id']);
            unset($_SESSION['permission']);
            echo "Logout successfully!";
            header("Location: ./index.php", true, 301);
            exit();
        }
    }
}