<?php

require_once '../Database/Connection.php';

use Database\Connection as Connection;

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    die();
}


$userId = isset($_POST['userId']) ? $_POST['userId'] : '';
$bookId = isset($_POST['bookId']) ? $_POST['bookId'] : '';


if (empty($userId) || empty($bookId)) {
    echo json_encode("");
    exit();
}

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();


$statement = $connection->prepare('SELECT * FROM notes WHERE user_id = :user_id AND book_id = :book_id');
$statement->bindParam('user_id', $userId);
$statement->bindParam('book_id', $bookId);
$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($results);
