<?php

$dns = 'mysql:host=xxx.chr7pe7iynqr.eu-west-1.rds.amazonaws.com;dbname=xxx';
$user = 'xxx';
$pass = 'xxx';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {
    $con = new PDO($dns, $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

    echo 'failed to connect' . $e->getMessage();
}

