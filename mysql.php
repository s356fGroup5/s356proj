<?php namespace mysql;

session_start();

function query($sql, $types, $params) {
    $conn = mysqli_connect('localhost', 'root', '', 'ouhks356_db');
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);


//    while (mysqli_fetch_assoc)
}
