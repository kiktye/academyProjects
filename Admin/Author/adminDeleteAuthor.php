<?php

session_start();

require_once(__DIR__ . '../../../Database/Connection.php');

use Database\Connection as Connection;

if (($_SESSION['user_type'] !== 'admin')) {
    header("Location: ../index.php");
    die();
}
$adminUsername = $_SESSION['username'];

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();

$authorId = $_POST['author_id'];
$currentDateTime = date('Y-m-d H:i:s');

$statement = $connection->prepare('UPDATE author SET deleted_at = :currentDateTime WHERE id = :author_id');
$statement->bindParam(':currentDateTime', $currentDateTime, PDO::PARAM_STR);
$statement->bindParam(':author_id', $authorId, PDO::PARAM_INT);
$statement->execute();

header('Location: ./author.php?msg=Author%20with%20id ' . $authorId . ' successfully%20soft%20deleted.');