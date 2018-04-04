<?php
// WARNING: This file is only for testing
require_once("mysql.php");
var_dump(\mysql\query("SELECT * FROM poll WHERE post_id = :id", ["id" => 79]));
