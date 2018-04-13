<?php require_once('header.php') ?>
<?php require_once("mysql.php"); ?>
<?php require_once('dbConnect.php'); ?>

<?php
//add to my favorites list
if (!empty($_POST["addflist"])) {
    if (!login_as()) {
        echo "<script>alert('Please Login first');</script>";
    } else

    $pid = isset($_GET["postid"]) ? $_GET["postid"] : fetch_latest_post_id();
        //TODO Fatal error: Call to undefined function mysql\query() in /www/getpost.php on line 68

    if ($pid == '' || login_as() == null) {
        echo "<script>alert('Error,missing value');</script>"; //TODO delete before implementing
    } else {
        require_once('dbConnect.php');

        $sql = "SELECT * FROM `favoritelist` 
                WHERE user_id = :user_id AND post_id= :pid;";

//            $result = mysqli_query($con, $sql);
//            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $row = \mysql\query($sql, ["user_id" => login_as(), "pid" => $pid])[0];
            //TODO null after refreshing

        if ($row["user_id"] == '' && $row["post_id"] == '') {
            $sql2 = "INSERT INTO `ouhks356_db`.`favoritelist` (`id`, `user_id`, `post_id`) 
                     VALUES (NULL," . "'" . $_SESSION['user_id'] . "'" . ",'" . $pid . "');";
            $result2 = mysqli_query($con, $sql2);
            echo "<script>alert('Added to your list successfully');</script>";

        } else if ($row["user_id"] == $_SESSION['user_id'] && $row["post_id"] == $pid) {
            echo "<script>alert('Record exist');</script>";
        }
    }
}
?>

<?php
function login_as() {
    if (isset($_SESSION['user_id'])) {
        return $_SESSION['user_id'];
    } else {
        return null;
    }
}

function is_allowed_to_vote_and_comment() {
    return login_as() != null && permission_of(login_as()) != 0;
}

function permission_of($user_id) {
    return intval(\mysql\query("SELECT (SELECT permission FROM user_type ut WHERE ut.type_id = u.type_id) AS permission
                         FROM user u WHERE user_id = :id", ["id" => $user_id])[0]["permission"]);
}

function is_blacklisted_by_me($user_id) {
    if (login_as()) {
        $sql = "SELECT * FROM blacklist WHERE blacklist_user_id = :target AND user_id = :me";
        return sizeof(\mysql\query($sql, ["target" => $user_id, "me" => login_as()])) > 0;
    } else {
        return false;
    }
}

//var_dump(is_blacklisted_by_me(51));

function fetch_latest_post_id() {
    return \mysql\query("SELECT post_id FROM post ORDER BY post_id DESC LIMIT 1")[0]["post_id"];
}

function fetch_post_info($post_id) {
    return \mysql\query("SELECT *, (SELECT username FROM user u WHERE p.user_id = u.user_id) AS username
                         FROM post p WHERE post_id = :id", ["id" => $post_id])[0];
}

function is_liked_or_disliked_by_me($comment, $category_id){
    if (login_as()){
        $sql = "SELECT * FROM poll_record 
                WHERE comment_id = :comment_id 
                AND user_id = :user_id 
                AND category_id = :category_id";
        return sizeof(\mysql\query($sql, ["comment_id" => $comment['comment_id'],
                                          "user_id" => login_as(),
                                          "category_id" => $category_id])) > 0;
    } else return false;
}

function like_or_dislike($comment, $category_id) { //category 0 = like, 1 = dislike
    if (!is_liked_or_disliked_by_me($comment, $category_id)){
        $sql = "INSERT INTO `poll_record` (`comment_id`, `user_id`, category_id, date, post_id) 
                VALUES (:comment_id, :user_id, :category_id, :date, :post_id)";
        \mysql\query($sql, ["comment_id" => $comment["comment_id"],
                            "user_id" => login_as(),
                            "category_id" => "category_id",
                            "date" => date('Y/m/d') . "",
                            "post_id" => $comment["post_id"]]);
    }
}

function render_post_info($post) { ?>
    <div>
        <h2><?php echo $post["title"]; ?></h2>
        <?php
        $params = ["type" => 1, "userid" => $post['user_id'], "postid" => $post['post_id'],
            "title" => $post['title'], "username" => $post['username']];
        $url = "report.php?" . http_build_query($params, '', '&amp;');
        ?>
        <a href="<?php echo $url; ?>">[Report this post]</a><br>
        Owner: <?php echo $post["username"]; ?><br>
        Created in: <?php echo $post["date"]; ?><br>

        <form method="post" onSubmit="return addtolist();">
            <button type="submit" name="addflist" id="addflist" value="Submit"
                    class="btn btn-secondary">Add to My favorites list
            </button>
        </form>
    </div>

<?php }

function render_comments($post) { ?><br>
    <table class="table table-bordered">
        <tbody>
        <?php // Comment

        $userpermit = login_as() ? permission_of(login_as()) : 0;

        $comments = \mysql\query("SELECT comment_id, comment, c.user_id, username, icon, c.post_id 
                                  FROM comment c, user u
                                  WHERE post_id = :id and c.user_id=u.user_id ORDER BY comment_id",
                                  ["id" => $post["post_id"]]);

        foreach ($comments as $index => $comment) {
            $i = $index + 1;

            // column 1: show user info.
            ?>
            <tr>
            <?php if ($userpermit == 0) { ?>
                <td align="center" width="25%" rowspan="2">
                    Comment <?php echo $index + 1; ?><br>
                    <img src="./images/icon/<?php echo $comment['icon']; ?>"><br>
                    <a href="./profile.php?userid=<?php echo $comment['user_id']; ?>">
                        <?php echo $comment['username']; ?>
                    </a>
                </td>
            <?php } else if ($userpermit == 140 || $userpermit == 255 || $userpermit == 256) { ?>
                <td align="center" width="25%" rowspan="2">
                    Comment <?php echo $index + 1; ?><br>
                    <a href="./edit.php?comment=<?php echo $comment['comment_id']; ?>">
                        [Edit]
                    </a>
                    <!-- TODO -->
                    <a href="./delete.php?postid=' . $comment['post_id'] . '&comment=' . $comment['comment_id'] . '">
                        [Delete]
                    </a>
                    <br>
                    <img src="./images/icon/<?php echo $comment['icon']; ?>"><br>
                    <a href="./profile.php?userid=<?php echo $comment['user_id']; ?>">
                        <?php echo $comment['username']; ?>
                    </a>
                </td>
            <?php } else if (login_as() == $comment['user_id']) { ?>
                <td align="center" width="25%" rowspan="2">
                    Comment <?php echo $index + 1; ?><br>
                    <a href="./edit.php?comment=<?php echo $comment['comment_id']; ?>">
                        [Edit]
                    </a>
                    <br>
                    <img src="./images/icon/<?php echo $comment['icon']; ?>"><br>
                    <a href="./profile.php?userid=' . $comment['user_id'] . '">
                        <?php echo $comment['username']; ?>
                    </a>
                </td>
            <?php } else { ?>
                <td align="center" width="25%" rowspan="2">
                    Comment <?php echo $index + 1; ?><br>
                    <img src="./images/icon/<?php echo $comment['icon']; ?>"><br>
                    <a href="./profile.php?userid=<?php echo $comment['user_id']; ?>">
                        <?php echo $comment['username']; ?>
                    </a>
                </td>
            <?php }

            // column 2: show comment
            if (is_blacklisted_by_me($comment["user_id"])) {
                echo '<td width="50%" rowspan="2"> This comment is blocked!</td>';
            } else {
                echo '<td width="50%" rowspan="2">' . $comment['comment'] . '</td>';
            }

            // column 3: show option for fav. & report
            if (login_as()) {
                if (login_as() == $comment['user_id']) { ?>
                    <td colspan="2" style="border-bottom: none">
                        <a class="btn btn-primary" href="./add_FavComment.php?comment_id=' . $comment['comment_id'] . '&post_id=' . $post['post_id'] . '">
                            [Add comment to Favorite]
                        </a>
                        <br>
                        <br>
                    </td>
                <?php } else { ?>
                    <td colspan="2" style="border-bottom: none">
                        <a class="btn btn-primary"
                           href="./add_FavComment.php?comment_id=' . $comment['comment_id'] . '&post_id=' . $post['post_id'] . '">
                            [Add comment to Favorite]
                        </a>
                        <br>
                        <br>
                        <a class="btn btn-danger"
                           href="./report.php?type=2&userid=' . $comment['user_id'] . '&postid=' . $post['post_id'] . '&commentid=' . $comment['comment_id'] . '&title=' . $post['title'] . '&comment=' . $comment['comment'] . '&username=' . $comment['username'] . '">
                            [Report this comment]
                        </a>
                        <br>
                        <br>
                        <a class="btn btn-danger"
                           href="./add_blacklist.php?blacklist=' . $comment['user_id'] . '">
                            [Add user to Blacklist!]
                        </a>
                    </td>
                <?php }
            } ?>
            <form method="post" action="">
                <tr style="border: none;">
                <?php
                $comment_id = $comment['comment_id'];
                $like = \mysql\query("SELECT COUNT(category_id) AS count 
                             FROM poll_record 
                             WHERE comment_id = :comment_id AND category_id = 0",
                             ["comment_id" => $comment_id])[0];
                $dislike = \mysql\query("SELECT COUNT(category_id) AS count 
                             FROM poll_record 
                             WHERE comment_id = :comment_id AND category_id = 1",
                             ["comment_id" => $comment_id])[0];
                ?>
                <td style="border: none; padding: 10px" valign="bottom">
                    <button style="border: none;" onclick="like_or_dislike();">
                        <img src="images/like.png" alt="like" style="height:30px; width:30px; border: none">
                    </button>
                    <?php echo $like['count'] ?>
                </td>
                <td style="border: none; padding: 10px" height="30px" valign="bottom">
                    <button style="border: none; ">
                        <img src="images/dislike.png" alt="like" style="height:30px; width:30px; border: none">
                    </button>
                    <?php echo $dislike['count'] ?>
                </td>
                </tr>
            </form>

        <?php } ?>
        </tbody>
    </table>

    <?php if (is_allowed_to_vote_and_comment()) { ?>
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

<?php }

function render_voting($post, $con) {
    $pid = $post["post_id"];
    ?>

    <form method="post" action="./vote.php">
        <table style="font-size: 16.5px; table-layout: fixed; width=100%; margin 15px 0">
            <?php
            //get user permission for different display
            if (login_as()) {
                $user_id = login_as();
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

            if (login_as()) {
                $voted = false;
                $user_id = login_as();
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
                            <input type="radio" name="vote" value="<?php echo $row2['poll_id']; ?>">
                        <?php } ?>
                    </td>
                    <td style="padding-top: 5px; word-wrap: break-word" height="35">
                        <?php echo $i; ?> . <?php echo $row2['poll_description']; ?>
                    </td>
                </tr>
                <tr>
                    <td height="35" style="padding-bottom: 5px">
                        <?php $progressbar = (((int)$row2['poll_count']) / $count_total) * 100 * $scale; ?>
                        <div class="percentbar" style="width:<?php echo 100 * $scale ?>px">
                            <div style="width:<?php echo $progressbar ?>px;"></div>
                        </div>
                    </td>
                    <td style="padding-bottom: 6px; padding-left: 5px; font-size: 14px">
                        <?php echo number_format((int)$row2['poll_count']/$count_total*100, 2, '.', '')?>% (<?php echo$row2['poll_count'] ?>)
                    </td>
                </tr>
                <?php
                $i++;
            } ?>
        </table>

        <?php
        if (login_as()) {
            if ($userpermit != 0) {
                $pid = isset($_GET["postid"])? $_GET["postid"] : fetch_latest_post_id();
                $user_id = login_as();
                $sql3 = "SELECT date, poll_description FROM poll_record pr, poll p WHERE user_id = '$user_id' AND pr.post_id = '$pid' AND p.poll_id = pr.poll_id";
                $result3 = mysqli_query($con, $sql3);
                $row3 = mysqli_fetch_assoc($result3);
                if (!isset($row3['date'])) { ?>
                    <input type="hidden" name="postid" value="<?php echo $pid ?>">
                    <br>
                    <input type="submit" value="Submit" class="btn">
                <?php } else {
                    echo "<br>You have already voted \"" . $row3['poll_description'] . "\" on " . $row3['date'];
                }
            } else{
                echo "<br>Blocked users are not eligible to vote.";
            }
        } else{
            echo "<br>Please login to vote this topic.";
        }
        ?>
    </form>

    <?php
}
?>

<html>
<link rel="stylesheet" type="text/css" href="css/style.css"/>

<style>
    .sidebar > div {
        display: flex;
        flex-direction: row;
        border-bottom: 1px solid rgb(221, 221, 221);
        padding: 6px 0;
    }

    .sidebar > div > div:first-child {
        width: 250px;
        margin-left: 9px;
    }

    .sidebar .title {
        font-weight: bold;
    }

</style>

<body>

<div class="panel">
    <div class="row">
        <div class="col-sm-4"> <!--left table-->
            <?php
            $sql = "SELECT * FROM post order by date DESC ";
            $result = mysqli_query($con, $sql);
            ?>
            <div class="sidebar">
                <div>
                    <div class="title">Title</div>
                    <div class="title">Date</div>
                </div>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div>
                        <div>
                            <?php $sql_vote = "SELECT poll_id FROM poll WHERE post_id = " . $row["post_id"];
                            $result_vote = mysqli_query($con, $sql_vote);
                            $row_vote = mysqli_fetch_assoc($result_vote);
                            if (isset($row_vote['poll_id'])) { ?>
                                <img src = "/images/vote.png" height = "25px" style = "padding-bottom: 10px" />
                            <?php }
                            $url = "?" . http_build_query(["postid" => $row["post_id"]], "", "&amp;"); ?>
                            <a href="<?php echo $url; ?>">
                                <?php echo $row["title"]; ?>
                            </a>
                        </div>
                        <div>
                            <?php echo $row["date"]; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="col-sm-8"> <!--right table-->
            <br>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php
                    $pid = isset($_GET["postid"])? $_GET["postid"] : fetch_latest_post_id(); //TODO "or" not working
                    $post = fetch_post_info($pid);
                    $category = $post["category_id"];

                    render_post_info($post);

                    if ($category == 1) {
                        render_comments($post);
                    } else if($category == 2) {
                        render_voting($post, $con);
                    }
                    ?>

                    <br>
                    <button onclick="window.location.href='./index.php'" style="align:right">Go Back</button>
                </div>
            </div>


        </div>
    </div>
</div>

</body>
</html>




