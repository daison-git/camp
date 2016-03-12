<?php

require_once('config.php');
require_once('functions.php');

// DBに接続
$id = $_GET['id'];
$flag = $_GET['flag'];

$dbh = connectDb();

if ($flag == 'delete') {
    $sql = "delete from tasks where id = :id";
} else {
    $sql = "update tasks set status = 'delete' where id = :id";
}


$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

header('Location: index.php');
exit;



