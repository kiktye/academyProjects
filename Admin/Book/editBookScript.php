<?php

session_start();

require_once(__DIR__ . '../../../Database/Connection.php');

use Database\Connection as Connection;

if (($_SESSION['user_type'] !== 'admin')) {
    header("Location: ../index.php");
    die();
}

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();

$adminUsername = $_SESSION['username'];
//

$bookId = $_POST['book_id'];
$bookTitle = $_POST['book_title'];
$bookPublishYear = $_POST['book_publish_year'];
$bookPages = $_POST['book_pages'];
$bookImage = $_POST['book_image'];
$bookAuthor = $_POST['book_author'];
$bookCategory = $_POST['book_category'];

$message = '';

if ($bookTitle === '') {
    $message = 'Book title cannot be empty.';
    return header('Location: ./adminEditBook.php?errorMsg=' . urlencode($message));
} else {
    $statement = $connection->prepare('UPDATE book
                SET book_title = :book_title, book_publish_year = :book_publish_year, book_pages = :book_pages, book_image = :book_image, author_id = :author_id, category_id = :category_id
                WHERE id = :id');
    $statement->bindParam(':book_title', $bookTitle);
    $statement->bindParam(':book_publish_year', $bookPublishYear);
    $statement->bindParam(':book_pages', $bookPages);
    $statement->bindParam(':book_image', $bookImage);
    $statement->bindParam(':author_id', $bookAuthor);
    $statement->bindParam(':category_id', $bookCategory);
    $statement->bindParam(':id', $bookId);
    $statement->execute();

    return header('Location: ./book.php');
}
