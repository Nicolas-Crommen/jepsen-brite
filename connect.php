<?php

$dns = 'mysql:host=localhost;dbname=jepsen-brite-db';
$user = 'root';
$pass = '';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);


try {
    $con = new PDO($dns, $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "You have access into the data base";
} catch (PDOException $e) {

    echo 'failed to connect' . $e->getMessage();
}
