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

$bookId = $_POST['book_id'];
$bookTitle = $_POST['book_title'];

$statement = $connection->prepare('DELETE FROM book WHERE id = :id AND book_title = :title');
$statement->bindParam(':id', $bookId);
$statement->bindParam(':title', $bookTitle);
$statement->execute();

$statementTwo = $connection->prepare('ALTER TABLE book AUTO_INCREMENT = 1');
$statementTwo->execute();

header('Location: ./book.php?msg=Book%20with%20id ' . $bookId . ' successfully%20deleted.');
