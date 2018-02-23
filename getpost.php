<?php
//add to my favorites list
if (!empty($_POST["addflist"])) {
    session_start();
    if ($_SESSION['username'] == "" && $_SESSION['user_id'] == "") {
        echo "<script>alert('Plz,Login first');</script>";
    }
    //header('location: '.$_SERVER['HTTP_REFERER']);

    $pid = $_GET["postid"];
    if ($pid == '' || $_SESSION['user_id'] == '') {
//echo "<script>alert('Error,missing value');</script>";
    } else {
        require_once('dbConnect.php');

        $sql = "SELECT * FROM `favoritelist` WHERE user_id =" . $_SESSION['user_id'] . " AND post_id=" . $pid . ";";

        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($row["user_id"] == '' && $row["post_id"] == '') {
            $sql2 = "INSERT INTO `ouhks356_db`.`favoritelist` (`id`, `user_id`, `post_id`) VALUES (NULL," . "'" . $_SESSION['user_id'] . "'" . ",'" . $pid . "');";
            $result2 = mysqli_query($con, $sql2);
            echo "<script>alert('Added to your list successfully');</script>";

        } else if ($row["user_id"] == $_SESSION['user_id'] && $row["post_id"] == $pid) {
            echo "<script>alert('Record exist');</script>";
        }
    }
}
?>

<?php include('header.php') ?>

<div class="panel">
    <div class="row">

        <div class="col-sm-4"> <!--left table-->

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
                echo '<tr><td><a href="?postid=' . $row["post_id"] . '">' . $row["title"] . '</a></td><td>' . $row["date"] . '</td></tr>';
            }
            echo '</tbody></table>';
            ?>


        </div>
        <div class="col-sm-8"> <!--right table-->
            <?php
            //importing dbConnect.php script
            require_once('dbConnect.php');

            //get newest post id for no pid value
            $get_postid = "SELECT post_id FROM post ORDER BY post_id DESC LIMIT 1";
            $statment = mysqli_query($con, $get_postid);
            $row = mysqli_fetch_assoc($statment);

            if (!isset($_GET["postid"])) {
                $pid = $row['post_id'];
            } else {
                $pid = $_GET["postid"];
            }

            if (isset($_SESSION['user_id'])) {
                $login = true;
                $user_id = $_SESSION['user_id'];
            } else {
                $login = false;
            }

            //Creating sql query
            $sql = "SELECT post_id, title, username, date, u.user_id FROM post p, user u WHERE post_id =$pid and p.user_id=u.user_id ;";
            $sql2 = "SELECT comment_id, comment, c.user_id, username, icon, c.post_id FROM comment c, user u WHERE post_id=$pid and c.user_id=u.user_id ORDER BY comment_id ;";
            if ($login) {
                $sql3 = "SELECT blacklist_user_id FROM blacklist WHERE user_id = $user_id";
            }
            //executing query
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $result2 = mysqli_query($con, $sql2);
            if ($login) {
                $result3 = mysqli_query($con, $sql3);
                $j = 0;
                $blacklist_check = array();
                while ($buser_list = mysqli_fetch_assoc($result3)) {
                    $blacklist_check[$j] = $buser_list['blacklist_user_id'];
                    $j++;
                }
            }
            ?>

            <br>
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <?php echo "<h2>" . $row["title"] . "</h2><br>";
                        echo '<a href="./report.php?type=1&userid=' . $row['user_id'] . '&postid=' . $row['post_id'] . '&title=' . $row['title'] . '&username=' . $row['username'] . '">[Report this post]</a>';
                        echo "<br>Owner: " . $row["username"] . "<br>Created in: " . $row["date"] . "<br>"; ?>
                        <?php
                        if ($login) {
                            if ($_SESSION['username'] != "" && $_SESSION['user_id'] != "") {
                                ?>
                                <form method="post" onSubmit="return addtolist();">

                                    <button type="submit" name="addflist" id="addflist" value="Submit"
                                            class="btn btn-secondary">Add to My favorites list
                                    </button>

                                </form>

                                <?php
                            }
                        }
                        ?>

                        </thead>
                        <tbody>

                        <?php // Comment
                        //get user permission for different display
                        if ($login) {
                            $user_id = $_SESSION['user_id'];
                            $get_userpermit = "SELECT type_id FROM user WHERE user_id = $user_id  ";
                            $stat = mysqli_query($con, $get_userpermit);
                            $rowst = mysqli_fetch_assoc($stat);
                            $userpermit = $rowst['permission'];
                        } else {
                            $userpermit = 0;
                        }

                        $i = 1;
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            // column 1: show user info.
                            if ($userpermit == 0) {
                                echo '<tr>
	                            <td align="center" width="25%">Comment ' . $i . '<br><img src="./images/icon/' . $row2['icon'] . '"><br> <a href="./profile.php?userid=' . $row2['user_id'] . '">' . $row2['username'] . '</a></td>';
                            } else if ($userpermit == 140 || $userpermit == 255 || $userpermit == 256) {
                                echo '<tr>
	                            <td align="center" width="25%">Comment ' . $i . ' <br><a href="./edit.php?comment=' . $row2['comment_id'] . '">[Edit]</a>' . ' <a href="./delete.php?postid=' . $row2['post_id'] . '&comment=' . $row2['comment_id'] . '">[Delete]</a>' . '<br><img src="./images/icon/' . $row2['icon'] . '"><br><a href="./profile.php?userid=' . $row2['user_id'] . '">' . $row2['username'] . '</a></td>';
                            } else if ($_SESSION['user_id'] == $row2['user_id']) {
                                echo '<tr>
			                    <td align="center" width="25%">Comment ' . $i . ' <br><a href="./edit.php?comment=' . $row2['comment_id'] . '">[Edit]</a>' . '<br><img src="./images/icon/' . $row2['icon'] . '"><br><a href="./profile.php?userid=' . $row2['user_id'] . '">' . $row2['username'] . '</a></td>';
                            } else {
                                echo '<tr>
			                    <td align="center" width="25%">Comment ' . $i . '<br><img src="./images/icon/' . $row2['icon'] . '"><br><a href="./profile.php?userid=' . $row2['user_id'] . '">' . $row2['username'] . '</a></td>';
                            }

                            // column 2: show comment
                            $checkvalue = "1";
                            if ($login) {
                                for ($k = 0; $k < $j; $k++) {
                                    if ($row2['user_id'] == $blacklist_check[$k]) {
                                        $checkvalue = "";
                                    }
                                }
                            }
                            if ($checkvalue != "") {
                                echo '<td width="50%">' . $row2['comment'] . '</td>';
                            } else {
                                echo '<td width="50%"> This comment is blocked!</td>';
                            }

                            // column 3: show option for fav. & report
                            if ($login) {
                                if ($_SESSION['username'] != '' && $_SESSION['user_id'] != '') {
                                    if ($_SESSION['user_id'] == $row2['user_id']) {
                                        echo '<td><a class="btn btn-primary" href="./add_FavComment.php?comment_id=' . $row2['comment_id'] . '&post_id=' . $row['post_id'] . '">[Add comment to Favorite]</a>
	  <br>
	  <br>
	  <a class="btn btn-danger" href="./report.php?type=2&userid=' . $row2['user_id'] . '&postid=' . $row['post_id'] . '&commentid=' . $row2['comment_id'] . '&title=' . $row['title'] . '&comment=' . $row2['comment'] . '&username=' . $row2['username'] . '">[Report this comment]</a>
	  </td>';
                                    } else {
                                        echo '<td><a class="btn btn-primary" href="./add_FavComment.php?comment_id=' . $row2['comment_id'] . '&post_id=' . $row['post_id'] . '">[Add comment to Favorite]</a>
	  <br>
	  <br>
	  <a class="btn btn-danger" href="./report.php?type=2&userid=' . $row2['user_id'] . '&postid=' . $row['post_id'] . '&commentid=' . $row2['comment_id'] . '&title=' . $row['title'] . '&comment=' . $row2['comment'] . '&username=' . $row2['username'] . '">[Report this comment]</a>
	  <br>
	  <br>
	  <a class="btn btn-danger" href="./add_blacklist.php?blacklist=' . $row2['user_id'] . '">[Add user to Blacklist!]</a>
	  </td>';
                                    }
                                }
                            }
                            echo '</tr>';
                            $i++;

                        }
                        ?>
                        </tbody>
                    </table>

                    <?php if ($userpermit != 0) { ?>
                        <form action="./reply.php" method=post>
                            Reply: <textarea name="reply" rows="10" cols="80" class="form-control"></textarea><br>
                            <?php
                            $pid = $_GET["postid"];
                            echo '<input type="hidden" name="postid" value="' . $pid . '"><br>';
                            ?>
                            <br>
                            <input type="submit" value="Submit" class="btn">

                        </form>
                    <?php } ?>


                    <br>
                    <button onclick="window.location.href='./index.php'" align='right'>Go Back</button>
                </div>
            </div>
        </div>


    </div>
</div>
</div>

</body>
</html>




