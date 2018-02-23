<?php include('header.php') ?>
<br><h1>My Favorite Comment</h1><br>
<div class="well">
    <button onclick="window.history.back();" align='right'>Go Back</button>
</div>

<div class="well">
    <form action="search_Fav.php" method="POST">
        <input type="text" name="search" placeholder="Search Comment">
        <button type="submit" name="submit">Search</button>
    </form>
</div>
<div class="panel">
    <?php
    //importing dbConnect.php script
    require_once('dbConnect.php');

    //Creating sql query
    $sql = "SELECT * FROM favoriteComment fc, comment c, post p 
			where fc.Comment_ID = c.Comment_ID and fc.post_id = p.post_id
			and fc.user_id=" . $_SESSION['user_id'] .
        " order by c.date DESC ";

    //executing query
    $result = mysqli_query($con, $sql);

    //fetching result
    echo '<table class="table table-hover" >';
    echo '<thead><tr><th>Comment</th><th>Post</th><th>DELETE</th></tr></thead>';
    echo '<tbody>';
    //echo'<tr><td>fake</td><td>fake date</td></tr>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['comment'] . "</td>";
        echo "<td><a href='./getpost.php?postid=" . $row['post_id'] . "'>" . $row['title'] . "</a></td>";
        echo '<td><a href="./delete_FavComment.php?comment=' . $row['comment_id'] . '">[DELETE FROM Favorite]</a></td>';
        echo "</tr>";
    }
    echo '</tbody></table>';
    ?>
</div>
</div>
</body>
</html>