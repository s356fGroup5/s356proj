<?php

require_once("util.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") die("not_post");
if (!\util\login_as()) die("not_logged_in");
if (!isset($_POST["comment_id"])) die("missing_comment_id");

$comment_id = $_POST["comment_id"];

if (\util\like($comment_id)) {
    echo json_encode(["count" => \util\like_count($comment_id), "success" => true]);
} else {
    echo json_encode(["success" => false]);
}
