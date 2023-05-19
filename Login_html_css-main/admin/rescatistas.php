
<!DOCTYPE html>
<html lang="es">

<!DOCTYPE html>
<html lang="es">

<head>

<!-- mapboxs-->
<script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
<!--mapboxs-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Añadir rescatista</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/modalCrud.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/burgerMenu.css">
    <script src="mainAdminCrud.js"></script>
</head>

<body>
  <?php
  include '../navigation.php';
  ?>
    <div class="contenedor">

        <div class="div-formulario">
            <h2>Formulario</h2>

            <form action="#" id="formulario">
                <input type="text" id="usuario" placeholder="Ingresa tu usuario">
                <input type="text" id="contrasena" placeholder="Ingresa tu contraseña">
                <input type="text" id="email" placeholder="Ingresa tu email">
                <button type="submit" id="btnAgregar">Agregar</button>
            </form>
        </div>

        <div class="div-listado">
            <h2>Listado Empleados</h2>
            <div class="div-empleados">
                
            </div>
        </div>

    </div>
  <!-- <script>apiCreate()</script> -->
</body>
</html>
