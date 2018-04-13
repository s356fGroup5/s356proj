<?php

$pid = $_GET['postid'];
if ($pid == 1)
    $pid2 = '<a style="color:red">Pending</a>';
else
    $pid2 = '<a>Done</a>';
echo $pid2;
?>

//try again
//re try again