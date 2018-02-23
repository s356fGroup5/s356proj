<?php
include 'dbConnect.php';
?>
<?php include('header.php') ?>
<html>
<head>
    <title>Search Favorite Comment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h1>Search Favorite Comment</h1><br>
    <div class="well">
        <button onclick="window.history.back();" align='right'>Go Back</button>
    </div>

    <div class="panel">
        <?php


        if (isset($_POST["submit"])) {
            $search = mysqli_real_escape_string($conn, $_POST['search']);
            $sql = "SELECT * FROM favoriteComment fc, comment c, post p 
		WHERE fc.Comment_ID = c.Comment_ID and fc.post_id = p.post_id 
		AND c.comment LIKE '%$search%'"; //not yet check utf8 and only for post title 
            $result = mysqli_query($conn, $sql);
            $queryResult = mysqli_num_rows($result);
            if ($queryResult > 0) {
                echo '<table class="table table-hover" >';
                echo '<thead><tr><th>Comment</th><th>Post</th><th>DELETE</th></tr></thead>';
                echo '<tbody>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['comment'] . "</td>";
                    echo "<td><a href='./getpost.php?postid=" . $row['post_id'] . "'>" . $row['title'] . "</a></td>";
                    echo '<td><a href="./delete_FavComment.php?comment=' . $row['comment_id'] . '">[DELETE FROM Favorite]</a></td>';
                    echo "</tr>";
                }
                echo '</tbody></table>';
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