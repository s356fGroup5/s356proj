<?php include('header.php') ?>
    <h1 onclick="window.location.href='./index.php'">Avatar &#x1F636</h1><br>


    <div class="panel">
        <?php
        //importing dbConnect.php script
        require_once('dbConnect.php');

        //Creating sql query
        $sql = "SELECT * FROM post order by date DESC ";

        //executing query
        $result = mysqli_query($con, $sql);

        //fetching result
        echo '<table class="table table-hover" >';
        echo '<thead><tr><th>Title</th><th>Date</th></tr></thead>';
        echo '<tbody>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr><td><a href="./getpost.php?postid=' . $row["post_id"] . '">' . $row["title"] . '</a></td><td>' . $row["date"] . '</td></tr>';
        }
        echo '</tbody></table>';
        ?>
    </div>
<?php include('footer.php') ?>