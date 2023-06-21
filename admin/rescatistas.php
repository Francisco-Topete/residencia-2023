
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
        <label class="btn btn-anadir" id="labelcrear" for="modal-create">+</label>
      </div>       
      <div class="div-empleados" id="gridUsers">
        <div class="grid-item header">Telefono</div>
        <div class="grid-item header">Nombre</div>
        <div class="grid-item header">Apellido</div>
        <div class="grid-item header">Tipo de Usuario</div>
        <div class="grid-item header">Acciones</div>
      </div>
      <script> retirarUsuarios(); </script>
    </div>
  </div>  

  <input class="modal-state" id="modal-create" name="modal-create" type="checkbox" />
  <div class="modal">
    <label class="modal__bg" for="modal-create"></label>
    <div class="modal__inner">
      <label class="modal__close" for="modal-create"></label>
      <div class="ui-form">
        <form id="crear_user" action="../api/apiCreateUser.php" method="post" onsubmit="return false;">
          <div class="form-flex-container">
            <div class="required field">
              <label class="label-field">Rol</label>
              <select id='crear-select-rol-usuario' name='tipo_usuario' class="select-box-rol" required>
                <option value="1">Administrador</option>
                <option value="2">Coordinador</option>
                <option value="3">Rescatista</option>
              </select>        
            </div>
            <div class="required field">
              <label class="label-field">Telefono</label>
              <input class="input-modal" id="crear-telefono-usuario" type="text" name="telefono" placeholder="(xxx) xxx-xxxx" required></input>
            </div>        
            <div class="required field">
              <label class="label-field">Nombre</label>
              <input class="input-modal" id="crear-nombre-usuario" type="text" name="nombre" placeholder="Nombre" required></input>
            </div>
            <div class="required field">
              <label class="label-field">Apellido</label>
              <input class="input-modal" id="crear-apellido-usuario" type="text" name="apellido" placeholder="Apellido" required></input>
            </div>               
            <div class="password-field-hide password-field-show field">
              <label class="label-field">Contrasena</label>
              <input class="input-modal" id="crear-password-usuario" type="password" name="contrasena" placeholder="********" required></input>
            </div>           
          </div>
          <div style="display: flex;">
            <input type="submit" onClick="verificarTelefono()" value="Crear" id="create" class="btn-submit"></input>
          </div>
        </form> 
      </div>
    </div>
  </div>

  <input class="modal-state" id="modal-modify" name="modal-modify" type="checkbox" />
  <div class="modal">
    <label class="modal__bg" for="modal-modify"></label>
    <div class="modal__inner">
      <label class="modal__close" for="modal-modify"></label>
      <div class="ui-form">
        <form id="modificar_user" action="../api/apiModifyUser.php" method="post" onsubmit="return false;">
          <div class="form-flex-container">
            <div class="required field">
              <label class="label-field">Rol</label>
              <select id='select-rol-usuario' name='tipo_usuario' class="select-box-rol" required>
                <option value="1">Administrador</option>
                <option value="2">Coordinador</option>
                <option value="3">Rescatista</option>
              </select>        
            </div>
            <div class="required field">
              <label class="label-field">Telefono</label>
              <input class="input-modal" id="telefono-usuario" type="text" name="telefono" placeholder="(xxx) xxx-xxxx" required></input>
              <input type="hidden" id="telefono-old" name="telefono_old" value="" required></input>
            </div>        
            <div class="required field">
              <label class="label-field">Nombre</label>
              <input class="input-modal" id="nombre-usuario" type="text" name="nombre" placeholder="Nombre" required></input>
            </div>
            <div class="required field">
              <label class="label-field">Apellido</label>
              <input class="input-modal" id="apellido-usuario" type="text" name="apellido" placeholder="Apellido" required></input>
            </div>               
            <div id="password-old-div" class="password-field-hide field" style="margin-top: 20px;">
              <label class="label-field-password">Contrasena actual</label>
              <input class="input-modal" id="password-usuario-old" type="password" name="contrasena_old" placeholder="********"></input>
            </div>
            <div id="password-new-div" class="password-field-hide field">
              <label class="label-field-password">Contrasena nueva</label>
              <input class="input-modal" id="password-usuario-new" type="password" name="contrasena_new" placeholder="********"></input>
            </div>
          </div>
          <div style="display: flex;">
            <button type="button" class="btn-password" onClick="cambiarContrasena()">Cambiar contraseña</button> 
            <input type="submit" onClick="verificarContrasena()" value="Modificar" id="modify" class="btn-submit"></input>
          </div>
        </form> 
      </div>
    </div>
  </div>

  <input class="modal-state" id="modal-delete" name="modal-delete" type="checkbox" />
  <div class="modal">
    <label class="modal__bg" for="modal-delete"></label>
    <div class="modal__inner">
      <label class="modal__close" for="modal-delete"></label>
      <div class="ui-form">
        <form id="crear_user" action="../api/apiDeleteUser.php" method="post">
          <div class="form-flex-container">           
            <div class="required field">
              <label class="label-field">Seguro que quieres borrar a este usuario?</label>  
              <input type="hidden" id="delete-telefono" name="delete-telefono" value="" required></input>           
            </div>                                     
          </div>
          <div style="display: flex;">
            <input type="submit" onClick="verificarTelefono()" value="Eliminar" id="delete" class="btn-submit"></input>
          </div>
        </form> 
      </div>
    </div>
  </div>

<script> setModalListener(); </script>
</body>
</html>
