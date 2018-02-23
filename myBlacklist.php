<?php include('header.php') ?>
<br><br><h1>Blacklist User</h1><br>
<div class="panel">
    <?php
    //importing dbConnect.php script
    require_once('dbConnect.php');

    //Creating sql query
    $sql = "SELECT * FROM blacklist bl, user u 
			where bl.user_id = u.user_id
			and bl.user_id=" . $_SESSION['user_id'];

    //executing query
    $result = mysqli_query($con, $sql);

    //fetching result
    echo '<table class="table table-hover" >';
    echo '<thead><tr><th>User ID</th><th>User Name</th><th>REMOVE</th></tr></thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        //echo $row['username'];
        echo "<tr>";
        $bl_ID = $row['blacklist_user_id'];
        echo "<td>" . $bl_ID . "</td>";

        $sql2 = "SELECT * FROM user where user_id =" . $bl_ID;
        //get blacklisted user name
        $result2 = mysqli_query($con, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        echo "<td><a href='./profile.php?userid=" . $row['blacklist_user_id'] . "'>" . $row2['username'] . "</a></td>";
        echo '<td><a href="./delete_blacklist.php?blacklist=' . $row['blacklist_user_id'] . '">[Remove FROM Blacklist]</a></td>';
        echo "</tr>";
    }
    echo '</tbody></table>';
    ?>
</div>
</div>
</body>
</html>