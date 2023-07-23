<?php
    session_start();
    session_destroy();
    unset($_SESSION['user-id']);
    unset($_SESSION['user-name']);
    unset($_SESSION['user-type']);
    unset($_SESSION['user-login']);
    header('Location: /');
    die();  
?>