<?php

require_once(__DIR__ . '../../../Database/Connection.php');

use Database\Connection as Connection;

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();

$author_first_name = $_POST['author_first_name'];
$author_last_name = $_POST['author_last_name'];
$author_biography = $_POST['author_biography'];

$message = '';


if ($author_first_name === '' || $author_last_name === '') {
    $message = 'First name and last name cannot be empty.';
    return header('Location: ./add-author.php?errorMsg=' . $message);
} else if ($author_biography === '' || strlen($author_biography) < 20) {
    $message = 'Author biography must be at least 20 characters.';
    return header('Location: ./add-author.php?errorMsg=' . $message);
} else {
    $statement = $connection->prepare('INSERT INTO `author` (`first_name`, `last_name`, `short_bio`) VALUES (:author_first_name, :author_last_name, :author_biography)');
    $statement->bindParam(':author_first_name', $author_first_name);
    $statement->bindParam(':author_last_name', $author_last_name);
    $statement->bindParam(':author_biography', $author_biography);
    $statement->execute();

    return header('Location: ./author.php');
}
