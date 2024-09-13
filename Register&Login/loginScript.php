<?php

session_start();
session_destroy();

require_once(__DIR__ . '/../Database/Connection.php');


use Database\Connection as Connection;

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();

$username = $_POST['username'];
$password = $_POST['password'];

// var_dump($password);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return header('Location: ./login-user.php');
} elseif ($username === '' or $password = '') {
    return header('Location: ./login-user.php?errorMsg=Enter%20your%20credentials.');
};

$statement = $connection->prepare('SELECT 
registered_users.id AS user_id,
registered_users.username AS username,
registered_users.password AS password,
user_type.type AS user_type

FROM registered_users JOIN user_type ON registered_users.user_type_id = user_type.id');
$statement->execute();

$users = $statement->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            if ($user['user_type'] === 'admin') {
                session_start();
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['user_id'];
                header('Location: ../Admin/adminDashboard.php');
                exit();
            }

            if ($user['user_type'] === 'user') {
                session_start();
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['user_id'];
                header('Location: ../index.php');
                exit();
            }
        } else {
            header('Location: ./login-user.php?errorMsg=Unknown%20credentials.');
        }
    }
}
