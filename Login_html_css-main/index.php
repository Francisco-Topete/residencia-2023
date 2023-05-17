<!DOCTYPE html>
<html lang="es">

<!-- Aqui llamamos todas las librerias y referencias necesarias para el funcionamiento de la plataforma web -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LOGIN</title>
    <!-- Pedimos las fuentes de google para utilizar dentro del mapa -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <div class="contenedor-formulario contenedor">
        <!-- Foto para decorar el inicio de sesion -->
        <div class="imagen-formulario">
            
        </div>
        <!-- Este es el formulario POST de inicio de sesion; el usuario introducira su numerod e telefono
    y contraseña -->
        <form method="post" action="login.php" class="formulario">
            <div class="texto-formulario">
                <h2>Bienvenido</h2>
                <p>Inicia sesión con tu cuenta</p>
            </div>
            <!-- Campo de telefono de usuario -->
            <div class="input">
                <label for="usuario">Usuario</label>
                <input placeholder="Ingresa tu telefono" type="text" name="usuario" required>
            </div>
            <!-- Campo de contraseña de usuario -->
            <div class="input">
                <label for="contraseña">Contraseña</label>
                <input placeholder="Ingresa tu contraseña" type="password" name="contrasena" required>
            <!-- Boton para iniciar sesion -->
            <div class="input">
                <input type="submit" name="ingresar" value="ingresar">
            </div>
        </form>
    </div>

</body>

</html>