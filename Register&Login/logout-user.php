<?php

session_start();
if((!isset($_SESSION['user_type']))){
    session_destroy();
    header("Location: ./login-user.php");
    die();
}

session_destroy();
header("Location: ../index.php");

?>