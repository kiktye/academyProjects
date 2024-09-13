<?php

require_once(__DIR__ . '../../../Database/Connection.php');

use Database\Connection as Connection;

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();

$category = $_POST['category_input'];

$message = '';

if ($category === '') {
    $message = 'Enter category!';
    return header('Location: ./add-category.php?errorMsg=' . $message);
} else {
    $statement = $connection->prepare('INSERT INTO `category` (`category_type`) VALUES (:category_type) ');
    $statement->execute(['category_type' => $category]);

    return header('Location: ./category.php');
}
