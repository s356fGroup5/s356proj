<?php

namespace util;
require_once("mysql.php");

function login_as() {
    if (isset($_SESSION['user_id'])) {
        return $_SESSION['user_id'];
    } else {
        return null;
    }
}

function is_liked_or_disliked_by_me($comment_id, $category_id){
    if (login_as()) {
        $sql = "SELECT * FROM poll_record 
                WHERE comment_id = :comment_id 
                AND user_id = :user_id 
                AND category_id = :category_id";

        $params = [
            "comment_id" => $comment_id,
            "user_id" => login_as(),
            "category_id" => $category_id
        ];

        return sizeof(\mysql\query($sql, $params)) > 0;
    } else {
        return false;
    }
}

function like_count($comment_id) {
    return _like_or_dislike_count($comment_id, 0);
}

function dislike_count($comment_id) {
    return _like_or_dislike_count($comment_id, 1);
}

function _like_or_dislike_count($comment_id, $category_id) {
    return \mysql\query("SELECT COUNT(*) AS count 
                         FROM poll_record 
                         WHERE comment_id = :comment_id AND category_id = :category_id",
                         ["comment_id" => $comment_id, "category_id" => $category_id])[0]["count"];
}

function like($comment_id) {
    if (!is_liked_or_disliked_by_me($comment_id, 0)) {
        _like_or_dislike($comment_id, 0);
        return true;
    } else {
        return false;
    }
}

function dislike($comment_id) {
    if (!is_liked_or_disliked_by_me($comment_id, 1)) {
        _like_or_dislike($comment_id, 1);
        return true;
    } else {
        return false;
    }
}

function _like_or_dislike($comment_id, $category_id) {
    $post_id = \mysql\query("SELECT post_id FROM comment
        WHERE comment_id = :comment_id", ["comment_id" => $comment_id])[0]["post_id"];

    $sql = "INSERT INTO `poll_record` (`comment_id`, `user_id`, category_id, date, post_id) 
            VALUES (:comment_id, :user_id, :category_id, :date, :post_id)";

    $params = [
        "comment_id" => $comment_id,
        "user_id" => login_as(),
        "category_id" => $category_id,
        "date" => (string) date('Y/m/d'),
        "post_id" => $post_id
    ];

    \mysql\execute($sql, $params);
}
