<?php

$dns = 'mysql:host=zpfp07ebhm2zgmrm.chr7pe7iynqr.eu-west-1.rds.amazonaws.com;dbname=k0m6n8erfpte57ew';
$user = 'c5rad2qrrojzyd3c';
$pass = 'd76kyt12ijglj4m0';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {
    $con = new PDO($dns, $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

    echo 'failed to connect' . $e->getMessage();
}
