<?php
require_once(__DIR__ . '../../../Database/Connection.php');

use Database\Connection as Connection;

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header("Location: ../index.php");
    die();
};

$comment = $_POST['comment'];
$user_id = $_POST['user_id'];
$book_id = $_POST['book_id'];
$admin_verified = FALSE;
$in_queue = TRUE;

if (empty($comment) || empty($user_id) || empty($book_id)) {
    header("Location:../index.php?errorMessage=Error!");
    exit;
}

if (strlen($comment) > 1000) {
    header("Location:./index.php?errorMessage=Comment%20must%20be%201000%20characters%20max!");
    exit;
}

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();


$statement = $connection->prepare("INSERT INTO comments (text, user_id, book_id, admin_verified, in_queue) 
        VALUES (:text, :user_id, :book_id, :admin_verified, :in_queue)");

$statement->bindParam('text', $comment);
$statement->bindParam('user_id', $user_id);
$statement->bindParam('book_id', $book_id);
$statement->bindParam('admin_verified', $admin_verified);
$statement->bindParam('in_queue', $in_queue);

if ($statement->execute()) {
    header ('Location: ../../bookAbout.php?bookId=' . $book_id . '&successMessage=Comment%20added%20to%20queue!');
} else {
    header("Location: ../../bookAbout.php?bookId=&errorMessage=Error!");
}
