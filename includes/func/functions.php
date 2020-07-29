<?php

function isExist($data, $tableName, $value)
{
    global $con;
    $stmt = $con->prepare("select $data FROM $tableName WHERE $data = ?");
    $stmt->execute([$value]);
    return $stmt->rowCount() > 0;
}


function formatDate($date)
{
    return date("D\  d-M-Y H\h i\m ", strtotime($date));
}
