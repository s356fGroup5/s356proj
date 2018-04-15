<?php

$comment_id = $_POST["comment_id"];
echo json_encode(["count" => \util\like_count($comment_id)]);
