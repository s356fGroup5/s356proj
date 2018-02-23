<?php include('header.php') ?>
<br><h1>My Favorite Post</h1><br>
<div class="well">
    <tr>
        <th align='center'><a href="./myComment.php">Favorite Comment</a></th>
    </tr>
</div>

<div class="panel">
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if ($_SESSION['username'] == "" && $_SESSION['user_id'] == "") {
        echo "<script>alert('Plz,Login first');</script>";
        echo "<script>history.go(-1);</script>";
    }

    //importing dbConnect.php script
    require_once('dbConnect.php');

    //Creating sql query
    //$sql = "SELECT * FROM favoritelist WHERE user_id = " .$_SESSION['user_id']. " order by id DESC ";

    $sql = "SELECT fc.id, fc.user_id, fc.post_id, p.title FROM favoritelist fc, post p
			where fc.post_id = p.post_id
			and fc.user_id=" . $_SESSION['user_id'] .
        " order by fc.id DESC ";


    // echo $sql;
    // exit;
    //executing query
    $result = mysqli_query($con, $sql);

    //fetching result
    echo '<table class="table table-hover" >';
    echo '<thead><tr><th>Post ID</th><th>Title</th></tr></thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr><td>' . $row["post_id"] . '</td><td><a href="./getpost.php?postid=' . $row["post_id"] . '">' . $row["title"] . '</a></td><td><a href="./delfpost.php?postid=' . $row['post_id'] . '">[Delete From HERE]</a></td><td>' . '</td></tr>';
    }
    echo '</tbody></table>';
    ?>
</div>
</div>
</body>
</html>