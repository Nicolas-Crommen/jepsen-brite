<?php

function isExist($data, $tableName, $value)
{
    global $con;
    $stmt = $con->prepare("select $data FROM $tableName WHERE $data = ?");
    $stmt->execute([$value]);
    return $stmt->rowCount() > 0;
}
