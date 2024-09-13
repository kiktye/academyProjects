<?php

require_once(__DIR__ . '/../Database/Connection.php');
require_once('./checkRegistered.php');

use Database\Connection as Connection;

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();


// Check if email is already registered
$usernames = array_unique(array_column($usernameData, 'username'));
$emails = array_unique(array_column($emailData, 'email'));

if (in_array($_POST['username'], $usernames)) {
    return header('Location:register-user.php?errorMsg=Username%20already%20registered.');
} else if (in_array($_POST['email'], $emails)) {
    return header('Location:register-user.php?errorMsg=Email%20already%20registered.');
} else {
    $userData = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ];
}



// Password Validation
function validatePassword($password)
{

    if (strlen($password) < 6) {
        return false;
    }
    if (!preg_match('/\d/', $password)) {
        return false;
    }
    if (!preg_match('/[A-Z]/', $password)) {
        return false;
    }
    if (!preg_match('/[!@#$%^&*]/', $password)) {
        return false;
    }

    return true;
}

if (!validatePassword($password)) {
    header("Location:./register.php?errorMessage=Password%20must%20contain%20at%20least%206%20characters,%20one%20number,%20uppercase%20letter%20and%20one%20special%20sign.");
}


$hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);

$statement = $connection->prepare('INSERT INTO `registered_users` (`username`, `email`, `password`, `user_type_id`) VALUES (:username, :email, :password, 2)');
$statement->bindParam(':email', $userData['email']);
$statement->bindParam(':username', $userData['username']);
$statement->bindParam(':password', $hashedPassword);
$statement->execute();

return header('Location: ./login-user.php');
