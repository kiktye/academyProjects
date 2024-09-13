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

$author_first_name = $_POST['author_first_name'];
$author_last_name = $_POST['author_last_name'];
$author_biography = $_POST['author_biography'];
$author_id = $_POST['author_id'];
$undelete = $_POST['undelete-author'] ?? "";

if ($undelete == "becomeUndeleted") {
    $undelete = NULL;

    $statement = $connection->prepare('UPDATE author
                SET first_name = :author_first_name, last_name = :author_last_name, short_bio = :author_biography, deleted_at = :undeleteValue
                WHERE id = :author_id');
    $statement->bindParam(':author_id', $author_id);
    $statement->bindParam(':author_first_name', $author_first_name);
    $statement->bindParam(':author_last_name', $author_last_name);
    $statement->bindParam(':author_biography', $author_biography);
    $statement->bindParam(':undeleteValue', $undelete);
    $statement->execute();

    header('Location: ./author.php?msg=Author%20with%20id ' . $author_id . ' successfully%20edited.');
}

$message = '';

if ($author_first_name === '' || $author_last_name === '') {
    $message = 'First name and last name cannot be empty.';
    return header('Location: ./adminEditAuthor.php?errorMsg=' . $message);
} else if ($author_biography === '' || strlen($author_biography) < 20) {
    $message = 'Author biography must be at least 20 characters.';
    return header('Location: ./adminEditAuthor.php?errorMsg=' . $message);
} else {

    $statement = $connection->prepare('UPDATE author
                SET first_name = :author_first_name, last_name = :author_last_name, short_bio = :author_biography
                WHERE id = :author_id');

    $statement->bindParam(':author_id', $author_id);
    $statement->bindParam(':author_first_name', $author_first_name);
    $statement->bindParam(':author_last_name', $author_last_name);
    $statement->bindParam(':author_biography', $author_biography);
    $statement->execute();

    header('Location: ./author.php?msg=Author%20with%20id ' . $author_id . ' successfully%20edited.');
}
