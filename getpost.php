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

<?php require_once('header.php') ?>
<?php require_once('dbConnect.php'); ?>
<link rel="stylesheet" type="text/css" href="css/style.css"/>

<div class="panel">
    <div class="row">

        <div class="col-sm-4"> <!--left table-->

            <?php
            $sql = "SELECT * FROM post order by date DESC ";
            $result = mysqli_query($con, $sql);
            ?>
            <table class="table table-hover">
            <thead><tr><th>Title</th><th>Date</th></tr></thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td>
                        <img src="/images/vote.png" height = "25px" style="padding-bottom: 10px"/>
                        <?php $url = "?" . http_build_query(["postid" => $row["post_id"]], "", "&amp;"); ?>
                        <a href="<?php echo $url; ?>"><?php echo $row["title"]; ?></a>
                    </td>
                    <td>
                        <?php echo $row["date"]; ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody></table>
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

            //post_category
            $sql = "SELECT post_id, category_id FROM post WHERE post_id=$pid";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            if ($row["category_id"]==1){

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
                        <div>
                            <h2><?php echo $row["title"]; ?></h2>
                            <?php
                            $params = ["type" => 1, "userid" => $row['user_id'], "postid" => $row['post_id'],
                               "title" => $row['title'], "username" => $row['username']];
                            $url = "report.php?" . http_build_query($params, '', '&amp;');
                            ?>
                            <a href="<?php echo $url; ?>">[Report this post]</a><br>
                            Owner: <?php echo $row["username"]; ?><br>
                            Created in: <?php echo $row["date"]; ?><br>
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
                        </div>
                        <table class="table table-bordered">
                            <tbody>
                            <?php // Comment
                            //get user permission for different display
                            if ($login) {
                                $user_id = $_SESSION['user_id'];
                                $get_userpermit = "SELECT permission FROM user_type ut, user u WHERE user_id = $user_id AND u.type_id = ut.type_id";
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
                                    <td align="center" width="25%" rowspan="2">Comment ' . $i . '<br><img src="./images/icon/' . $row2['icon'] . '"><br> <a href="./profile.php?userid=' . $row2['user_id'] . '">' . $row2['username'] . '</a></td>';
                                } else if ($userpermit == 140 || $userpermit == 255 || $userpermit == 256) {
                                    echo '<tr>
                                    <td align="center" width="25%" rowspan="2">Comment ' . $i . ' <br><a href="./edit.php?comment=' . $row2['comment_id'] . '">[Edit]</a>' . ' <a href="./delete.php?postid=' . $row2['post_id'] . '&comment=' . $row2['comment_id'] . '">[Delete]</a>' . '<br><img src="./images/icon/' . $row2['icon'] . '"><br><a href="./profile.php?userid=' . $row2['user_id'] . '">' . $row2['username'] . '</a></td>';
                                } else if ($_SESSION['user_id'] == $row2['user_id']) {
                                    echo '<tr>
                                    <td align="center" width="25%" rowspan="2">Comment ' . $i . ' <br><a href="./edit.php?comment=' . $row2['comment_id'] . '">[Edit]</a>' . '<br><img src="./images/icon/' . $row2['icon'] . '"><br><a href="./profile.php?userid=' . $row2['user_id'] . '">' . $row2['username'] . '</a></td>';
                                } else {
                                    echo '<tr>
                                    <td align="center" width="25%" rowspan="2">Comment ' . $i . '<br><img src="./images/icon/' . $row2['icon'] . '"><br><a href="./profile.php?userid=' . $row2['user_id'] . '">' . $row2['username'] . '</a></td>';
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
                                    echo '<td width="50%" rowspan="2">' . $row2['comment'] . '</td>';
                                } else {
                                    echo '<td width="50%" rowspan="2"> This comment is blocked!</td>';
                                }

                                // column 3: show option for fav. & report
                                if ($login) {
                                    if ($_SESSION['username'] != '' && $_SESSION['user_id'] != '') {
                                        if ($_SESSION['user_id'] == $row2['user_id']) {
                                            echo '<td colspan="2" style="border-bottom: none"><a class="btn btn-primary" href="./add_FavComment.php?comment_id=' . $row2['comment_id'] . '&post_id=' . $row['post_id'] . '">[Add comment to Favorite]</a>
          <br>
          <br>
          <a class="btn btn-danger" href="./report.php?type=2&userid=' . $row2['user_id'] . '&postid=' . $row['post_id'] . '&commentid=' . $row2['comment_id'] . '&title=' . $row['title'] . '&comment=' . $row2['comment'] . '&username=' . $row2['username'] . '">[Report this comment]</a>
          </td>';
                                        } else {
                                            echo '<td colspan="2" style="border-bottom: none"><a class="btn btn-primary" href="./add_FavComment.php?comment_id=' . $row2['comment_id'] . '&post_id=' . $row['post_id'] . '">[Add comment to Favorite]</a>
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
                                echo '<tr style="border: none;">';
                                $comment_id = $row2['comment_id'];
                                $sql_like = "SELECT COUNT(category_id) AS count FROM poll_record WHERE comment_id = $comment_id AND category_id = 0";
                                $sql_dislike = "SELECT COUNT(category_id) AS count FROM poll_record WHERE comment_id = $comment_id AND category_id = 1";
                                $result_like = mysqli_query($con, $sql_like);
                                $result_dislike = mysqli_query($con, $sql_dislike);
                                $like = mysqli_fetch_assoc($result_like);
                                $dislike = mysqli_fetch_assoc($result_dislike);
                                $style = "border: none !important; padding: 10px !important";
                                if (!$login) {
                                    $style = " padding: 10px";
                                }
                                ?>
                                <td style= ' . $style . ' height="30px" valign="bottom">
                                <td style="border: none; padding: 10px" height="30px" valign="bottom">
                                    <button style="border: none;">
                                        <img src="images/like.png" alt="like" style="height:30px; width:30px; border: none">
                                    </button>
                                    <?php echo $like['count'] ?>
                                </td>
                                <td style="<?php echo $style; ?>" height="30px" valign="bottom">
                                <td style="border: none; padding: 10px" height="30px" valign="bottom">
                                <button style="border: none; "><img src="images/dislike.png" alt="like" style="height:30px; width:30px; border: none"></button>
                                <?php echo $dislike['count'] ?>
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }?>
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
        <?php
        } else if($row["category_id"]==2){

                //Creating sql query
                $sql = "SELECT post_id, title, username, date, u.user_id FROM post p, user u WHERE post_id =$pid and p.user_id=u.user_id ;";
                if ($login) {
                    $sql3 = "SELECT blacklist_user_id FROM blacklist WHERE user_id = $user_id";
                }
                //executing query
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
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
<!--                        <table class="table table-bordered">-->
                        <table>
                            <thead>
                            <?php echo "<h2>" . $row["title"] . "</h2><br>";
                            echo '<a href="./report.php?type=1&userid=' . $row['user_id'] . '&postid=' . $row['post_id'] . '&title=' . $row['title'] . '&username=' . $row['username'] . '">[Report this post]</a>';
                            echo "<br>Owner: " . $row["username"] . "<br>Created in: " . $row["date"] . "<br>"; ?>
                            <?php
                            if ($login) {
                                if ($_SESSION['username'] != "" && $_SESSION['user_id'] != "") {
                                    ?>
                                    <form method="post" onSubmit="return addtolist();" >
                                        <button type="submit" name="addflist" id="addflist" value="Submit" class="btn btn-secondary">Add to My favorites list</button>
                                    </form>
                                    <?php
                                }
                            }
                            ?>
                            </thead>
                        </table>

                            <form method="post" action="./vote.php">
                                <table style="font-size: 16.5px; table-layout: fixed; width=100%; margin 15px 0">
                                    <?php
                                    //get user permission for different display
                                    if ($login) {
                                        $user_id = $_SESSION['user_id'];
                                        $get_userpermit = "SELECT permission FROM user_type ut, user u WHERE user_id = $user_id AND u.type_id = ut.type_id";
                                        $stat = mysqli_query($con, $get_userpermit);
                                        $rowst = mysqli_fetch_assoc($stat);
                                        $userpermit = $rowst['permission'];
                                    } else {
                                        $userpermit = 0;
                                    }

                                    $sql2 = "SELECT poll_description, poll_count, post_id, poll_id FROM poll WHERE post_id=$pid ORDER BY poll_id ;";
                                    $result2 = mysqli_query($con, $sql2);
                                    $sql_count_total = "SELECT SUM(poll_count) as total From poll WHERE post_id = $pid";
                                    $result_count_total = mysqli_query($con, $sql_count_total);
                                    $row_count_total = mysqli_fetch_assoc($result_count_total);
                                    $count_total = (int)$row_count_total['total'];
                                    $scale = 6.0;
                                    $i = 1;

                                    if ($login) {
                                        $voted = false;
                                        $sql3 = "SELECT date FROM poll_record WHERE user_id = '$user_id' AND post_id = '$pid'";
                                        $result3 = mysqli_query($con, $sql3);
                                        $row3 = mysqli_fetch_assoc($result3);
                                        if (isset($row3['date'])) {
                                            $voted = true;
                                        }
                                    }

                                    while ($row2 = mysqli_fetch_assoc($result2)){
                                        ?>
                                        <tr>
                                        <td width="50px" rowspan="2" align="center" height="70">
                                        <?php if ($userpermit != 0 && !$voted) { ?>
                                             <input type="radio" name=vote value="<?php $row2['poll_id']; ?>">
                                        <?php } ?>
                                        </td>
                                        <td style="padding-top: 5px; word-wrap: break-word" height="35"><?php echo $i; ?>. <?php echo $row2['poll_description']; ?></td>
                                        <tr>
                                        <td height="35" style="padding-bottom: 5px">
                                        <?php $progressbar = (((int)$row2['poll_count']) / $count_total) * 100 * $scale; ?>
                                        <div class="percentbar" style="width:<?php echo 100 * $scale ?>">
                                        <div style="width:'<?php echo $progressbar ?>';"></div>
                                        </div>
                                        <td style="padding-bottom: 6px; padding-left: 5px; font-size: 14px">
                                                <?php echo number_format((int)$row2['poll_count']/$count_total*100, 2, '.', '')?> . % (<?php echo$row2['poll_count'] ?> . )
                                            </td>
                                        </td>
                                        </tr>
                                        </tr>
                                        </tr>
                                        <?php
                                        $i++;
                                    } ?>
                                </table>

                                <?php
//                              if ($userpermit != 0) {
                                if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
                                    if ($userpermit != 0) {
                                        if (!isset($_GET["postid"])) {
                                            $pid = $row['post_id'];
                                        } else {
                                            $pid = $_GET["postid"];
                                        }
                                        $user_id = $_SESSION['user_id'];
                                        $sql3 = "SELECT date, poll_description FROM poll_record pr, poll p WHERE user_id = '$user_id' AND pr.post_id = '$pid' AND p.poll_id = pr.poll_id";
                                        $result3 = mysqli_query($con, $sql3);
                                        $row3 = mysqli_fetch_assoc($result3);
                                        if (!isset($row3['date'])) {
                                            echo '<input type="hidden" name="postid" value="' . $pid . '"><br>';
                                            echo '<input type="submit" value="Submit" class="btn">';
                                        } else {
                                            echo "<br>You have already voted \"" . $row3['poll_description'] . "\" on " . $row3['date'];
                                        }
                                    } else{
                                        echo "<br>Blocked users are not eligible to vote.";
                                    }
                                } else{
                                    echo "<br>Please login for voting the topic.";
                                }
                                ?>
                            </form>

                        <br>
                        <button onclick="window.location.href='./index.php'" align='right'>Go Back</button>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>


    </div>
</div>
</div>

</body>
</html>




