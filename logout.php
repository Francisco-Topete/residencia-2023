<?php
    session_start();
    session_destroy(); //Se destruye la sesión, para que no pueda volver a llamarse.
    unset($_SESSION['user-id']); //Se destruyen manualmente todos los datos de la sesión para limpiar el cache.
    unset($_SESSION['user-name']);
    unset($_SESSION['user-type']);
    unset($_SESSION['user-login']);
    header('Location: /'); //Lleva al usuario devuelta al index (inicio de sesión).
    die();  //Acaba el tiempo de vida del PHP para no consumir memoria.
?>