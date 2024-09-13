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


$categoryId = $_POST['category_id'];
$currentDateTime = date('Y-m-d H:i:s');

$statement = $connection->prepare('UPDATE category SET deleted_at = :currentDateTime WHERE id = :category_id');
$statement->bindParam(':currentDateTime', $currentDateTime, PDO::PARAM_STR);
$statement->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
$statement->execute();

header('Location: ./category.php?msg=Category%20with%20id ' . $categoryId . ' successfully%20soft%20deleted.');
