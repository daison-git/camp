<?php

require_once('config.php');
require_once('functions.php');

// DBに接続
$id = $_GET['id'];

$dbh = connectDb();

// $sql = "update tasks set status = 'delete' where id = :id";
$sql = "delete from tasks where id = :id";

$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

header('Location: index.php');
exit;



