
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
    <title>Administrar usuarios</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/modalCrud.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/estilosAdmin.css">
    <link rel="stylesheet" href="../css/burgerMenu.css">
    <script src="mainAdminCrud.js"></script>
</head>

<body>
  <?php
  include '../navigation.php';
  ?>

  <div class="contenedor">
    <div class="div-listado">
        <div class="div-header">
          <h2>Usuarios</h2>
          <label class="btn btn-anadir" for="modal-1">+</label>
        </div>       
        <div class="div-empleados">
          <div class="grid-item userphone">1</div>
          <div class="grid-item username">2</div>
          <div class="grid-item userlname">3</div>
          <div class="grid-item usertype">4</div>
        </div>
    </div>
  </div>  

  <input class="modal-state" id="modal-1" type="checkbox" />
  <div class="modal">
    <label class="modal__bg" for="modal-1"></label>
    <div class="modal__inner">
      <label class="modal__close" for="modal-1"></label>

      <div class="ui form">
        <form id="create_user" style="margin-bottom: 30px">
          <div class="required field">
            <label>Telefono</label>
            <input id="name" type="text" name="name" placeholder="Name" />
          </div>
          <div class="required field">
            <label>Contrasena</label>
            <input id="birthday" type="password" name="birthday" placeholder="********"></input>
          </div>
          <div class="required field">
            <label>Nombre</label>
            <input id="phone" type="text" name="phone" placeholder="(664) 123-4567"></input>
          </div>
          <div class="field">
            <label>Apellido</label>
            <input id="email" type="email"  name="email" placeholder="joe@schmoe.com">
          </div>
          <div class="required field">
            <label>Rol</label>
            <select class="select-box-rol">
              <option value="">Elige una opcion</option>
              <option value="">Rescatista</option>
              <option value="">Moderador</option>
            </select>
          </div>
        </form>

        <div style="display: flex; justify-content: center">
          <a id="back" class="ui basic button" href="index.html">Back</a>
          <button id="create" class="ui submit button" onClick="apiCreate()">
            Create
          </button>
        </div>
      </div>
    </div>
  </div>


  


  
  <!-- <script>apiCreate()</script> -->
</body>
</html>
