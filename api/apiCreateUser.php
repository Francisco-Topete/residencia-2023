<?php
//Esta API es para crear a los usuarios, por medio del CRUD.

//Se llama la conexión a la base de datos.
include '../sqlservercall.php';

if (!empty($_POST['telefono'])) //Si se reciben los datos del formulario de la webapp, se asignan a un JSON:
{
    $data = array(
        "telefono" => $_POST['telefono'],
        "nombre" => $_POST['nombre'],
        "apellido" => $_POST['apellido'],
        "tipo_usuario" => $_POST['tipo_usuario'],
        "contrasena" => $_POST['contrasena'],
    );
}
else //Si se recibe de la aplicación movil, solo se recibe el JSON.
{
    $json = file_get_contents('php://input');
    $data = json_decode($json,true);
}

//Se crea una bandera para confirmar o prohibir la creación del usuario.
$create = false;

//Se verifica si el telefono ya existe en la base de datos.
$params = array($data['telefono']); 
$query = sqlsrv_query( $conn, "EXEC dbo.VerificarTelefono @Telefono = ?;",$params); 
                                    
$row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC); 
         
//Si no se encontro nada, entonces la bandera permite la creación del nuevo usuario.
if (!$row['Telefono_Usuario']) 
{ 
    $create = true;
}   

//Crea el usuario.
if($create)
{
    $paramsCreate = array($data['telefono'], $data['nombre'], $data['apellido'], 
                        $data['contrasena'], $data['tipo_usuario']); 

    $query= sqlsrv_query( $conn, "EXEC dbo.CrearUsuario @Telefono = ?, 
                        @Nombre = ?, @Apellido = ?, @Contrasena_Usuario = ?, 
                        @Tipo = ?;", $paramsCreate);
                        
    $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC); 
    $POST = array("creacion"=>"aceptada");
    echo json_encode($POST);
}
else //Si llega a encontrar el usuario, la bandera se queda como falsa, y rechaza la creación del nuevo usuario.
{
    $POST = array("creacion"=>"rechazada");
    echo json_encode($POST);
}

//Redirige a la pantalla de administración.
header("Location: ../admin/rescatistas");
?>