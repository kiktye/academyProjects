<?php

require_once(__DIR__ . '../../../Database/Connection.php');

use Database\Connection as Connection;

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();

$bookTitle = $_POST['book_title'];
$bookPublishYear = $_POST['book_publish_year'];
$bookPages = $_POST['book_pages'];
$bookImage = $_POST['book_image'];
$bookAuthor = $_POST['book_author'];
$bookCategory = $_POST['book_category'];

$message = '';



if ($bookTitle === '') {
    $message = 'Book title cannot be empty.';
    return header('Location: ./add-book.php?errorMsg=' . $message);
} else {
    $statement = $connection->prepare('INSERT INTO `book` (`book_title`, `book_publish_year`, `book_pages`, `book_image`, `author_id`, `category_id`) VALUES (:book_title, :book_publish_year, :book_pages, :book_image, :book_author, :book_category)');
    $statement->bindParam(':book_title', $bookTitle);
    $statement->bindParam(':book_publish_year', $bookPublishYear);
    $statement->bindParam(':book_pages', $bookPages);
    $statement->bindParam(':book_image', $bookImage);
    $statement->bindParam(':book_author', $bookAuthor);
    $statement->bindParam(':book_category', $bookCategory);
    $statement->execute();

    return header('Location: ./book.php');
}
