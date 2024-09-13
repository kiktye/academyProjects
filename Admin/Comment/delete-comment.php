<?php
require_once(__DIR__ . '../../../Database/Connection.php');

use Database\Connection as Connection;

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();

$userId = $_POST['user_id'];
$bookId = $_POST['book_id'];

if ($_SERVER['REQUEST_METHOD'] !== "POST" || empty($bookId) || empty($userId)) {
    header("Location:login.php");
    die();
};

$statement = $connection->prepare("DELETE FROM comments WHERE user_id = :user_id AND book_id = :book_id");
$statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
$statement->bindParam(':book_id', $bookId, PDO::PARAM_INT);
$statement->execute();

header("Location: ../../bookAbout.php?bookId=" . $bookId . "&successMessage=Comment%20deleted%20successfully!");
