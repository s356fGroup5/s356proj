<?php namespace mysql;

if(!isset($_SESSION)) {
    session_start();
}

function query($sql, $params = []) {
    $conn = new \PDO("mysql:dbname=ouhks356_db;host=localhost", "root", "");
    $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue(":" . $key, $value);
    }
    $stmt->execute();
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    return $result;
}

function execute($sql, $params = []) {
    $conn = new \PDO("mysql:dbname=ouhks356_db;host=localhost", "root", "");
    $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue(":" . $key, $value);
    }
    $stmt->execute();
}
