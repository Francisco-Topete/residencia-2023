<?php
    session_start();

    if(!isset($_SESSION['user-login']) || !$_SESSION['user-login'])
    {
        session_destroy();
        unset($_SESSION['user-id']);
        unset($_SESSION['user-name']);
        unset($_SESSION['user-type']);
        unset($_SESSION['user-login']);
        header('Location: /');
        die();
    }
?>