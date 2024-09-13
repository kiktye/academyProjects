<?php

require_once(__DIR__ . '/../Database/Connection.php');

use Database\Connection as Connection;

    $connectionObj = new Connection();
    $connection = $connectionObj->getConnection();
    
    $statement = $connection->prepare('SELECT email FROM registered_users');
    $statement->execute();
    $emailData = $statement->fetchAll(PDO::FETCH_ASSOC);


    $statementTwo = $connection->prepare('SELECT username FROM registered_users');
    $statementTwo->execute();
    $usernameData = $statementTwo->fetchAll(PDO::FETCH_ASSOC);



?>