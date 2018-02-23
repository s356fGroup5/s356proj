<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DB', 'ouhks356_db');

$con = mysqli_connect(HOST, USER, PASS, DB) or die('Unable to Connect');
$conn = mysqli_connect(HOST, USER, PASS, DB) or die('Unable to Connect');
mysqli_set_charset($con, "utf8");
mysqli_set_charset($conn, "utf8");
