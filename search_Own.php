<?php
require_once('dbConnect.php');
?>
<?php include('header.php') ?>
<html>
<head>
    <title>Search Comment Result</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h1>Search Result</h1><br>

    <div>
        <button onclick='window.history.back();' align='right'>Go Back</button>
    </div>
    <div class="panel">
        <?php
        //echo $_POST["search"];
        if (isset($_POST["search"])) {
            $search = $_POST["search"];
            $sql = "SELECT c.comment,p.title,c.date,p.post_id FROM comment c,post p WHERE c.post_id=p.post_id AND c.user_id=" . $_SESSION['user_id'] . " AND c.comment LIKE '%$search%'";
            $result = mysqli_query($con, $sql);
            $queryResult = mysqli_num_rows($result);

            if ($queryResult > 0) {
                echo '<table class="table table-hover" >';
                echo '<thead><tr><th>Comment</th><th>Post</th><th>Comment Date</th></tr></thead>';
                echo '<tbody>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['comment'] . "</td>";
                    echo "<td><a href='./getpost.php?postid=" . $row['post_id'] . "'>" . $row['title'] . "</a></td>";
                    echo "<td>" . $row['date'] . "</td>";
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