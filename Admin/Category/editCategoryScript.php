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


$category_id = $_POST['category_id'];
$category_type = $_POST['category_input'];
$undelete = $_POST['undelete-category'] ?? "";

if ($undelete == "becomeUndeleted") {
    $undelete = NULL;

    $statement = $connection->prepare('UPDATE category
                SET category_type = :category_type, deleted_at = :undeleteValue
                WHERE id = :categoryId');
    $statement->bindParam(':categoryId', $category_id);
    $statement->bindParam(':category_type', $category_type);
    $statement->bindParam(':undeleteValue', $undelete);
    $statement->execute();

    header('Location: ./category.php?msg=Category%20with%20id ' . $category_id . ' successfully%20edited.');
}

$message = '';

if ($category_type === '') {
    $message = 'Enter category!';
    return header('Location: ./adminEditCategory.php?errorMsg=' . $message);
} else {

    $statement = $connection->prepare('UPDATE category
                SET category_type = :category_type WHERE id = :category_id');

    $statement->bindParam(':category_id', $category_id);
    $statement->bindParam('category_type', $category_type);
    $statement->execute();

    header('Location: ./category.php?msg=Category%20with%20id ' . $category_id . ' successfully%20edited.');
}
