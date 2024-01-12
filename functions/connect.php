<?php
$host = "mysql:host=127.0.0.1;dbname=wonder-software";
$db_user = "root";
$db_pass = "";
$option = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
];
try {
    $con = new PDO($host, $db_user, $db_pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
}

$curr_lang = $_COOKIE['wonder_language'];
