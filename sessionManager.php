<?php
    //Este PHP se encarga de manejar la sesión del usuario, osease, la cuenta del usuario.
    session_start(); //Se inicia la sesión.

    //Este if es para evitar que personas que no hayan iniciado sesión accedan al sitio de forma directa.
    //Si la variable que indica que el usuario inicio sesión no esta declarada O esta declarada como false:
    if(!isset($_SESSION['user-login']) || !$_SESSION['user-login']) 
    {
        session_destroy(); //Por precaución, se destruye alguna posible sesión anterior.
        unset($_SESSION['user-id']); //Se borra cualquier dato, de nuevo, por precaución
        unset($_SESSION['user-name']);
        unset($_SESSION['user-type']);
        unset($_SESSION['user-login']);
        header('Location: /'); //Te manda a la pagina de inicio de sesión
        die(); //Mata el PHP
    }
?>