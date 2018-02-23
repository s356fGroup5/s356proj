<?php
require_once('dbConnect.php');
?>
<html>
<head>
    <title>Search page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h1>Search page</h1><br>
    <div class="well">
        <a href="./login.php">Login</a>
        <a href="./register.php">Register</a>
        <a href="./profile.php">Profile</a>
        <a href="./createpost.php">Create Post</a>
        <a href="./admin.php">Admin</a>
    </div>
    <div class="panel">
        <?php
        //echo "testing and the search is:".$_POST["search"];

        if (isset($_POST["search"])) {
            $search = $_POST["search"];

            $sql = "SELECT * FROM post WHERE title LIKE '%$search%' OR date LIKE '%$search%' ";
            $result = mysqli_query($con, $sql);
            $queryResult = mysqli_num_rows($result);
            if ($queryResult > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<a href="getpost.php?postid=' . $row['post_id'] . '""><div class="panel">';
                    echo "<h3>" . $row['title'] . "</h3>";

                    echo "<p>" . $row['date'] . "</p>";

                    echo "</div></a>";
                }
            } else {
                echo "There are no post.";
            }
        } else {
            echo "There are no results!";
        }
        ?>
    </div>


</div>
</div>
</body>
</html>