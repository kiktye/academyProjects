<?php
require_once(__DIR__ . '../../../Database/Connection.php');

use Database\Connection as Connection;

session_start();
if (($_SESSION['user_type'] !== 'admin')) {
    header("Location:../../login.php?errorMessage=Enter%20username%20and%20password!");
    die();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location:../../login.php?errorMessage=Enter%20username%20and%20password!");
    die();
}

$adminUsername = $_SESSION['username'];

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();

$bookId = $_POST['book_id'];
$userId = $_POST['user_id'];

print_r("The book id is: " . $bookId . " <br>");
print_r("The user id is: " . $userId . " <br>");


$statement = $connection->prepare("UPDATE comments SET admin_verified = 1, in_queue = 0 WHERE book_id = :book_id AND user_id = :user_id");
$statement->bindParam(':book_id', $bookId);
$statement->bindParam(':user_id', $userId);
$statement->execute();

header('Location: ./comment.php?message=Comment%20approved!');
