<?php

include '../sqlservercall.php';

if (!empty($_POST['telefono'])) //Si se reciben los datos del formulario en index, se hara lo siguiente:
{
    $data = array(
        "telefono" => $_POST['telefono'],
        "nombre" => $_POST['nombre'],
        "apellido" => $_POST['apellido'],
        "tipo_usuario" => $_POST['tipo_usuario'],
        "contrasena" => $_POST['contrasena'],
    );
}
else
{
    $json = file_get_contents('php://input');
    $data = json_decode($json,true);
}

$create = false;

$params = array($data['telefono']); 
$query = sqlsrv_query( $conn, "EXEC dbo.VerificarTelefono @Telefono = ?;",$params); 
                                    
$row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC); 
                                                                                                                    
if (!$row['Telefono_Usuario']) 
{ 
    $create = true;
}   

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
else
{
    $POST = array("creacion"=>"rechazada");
    echo json_encode($POST);
}

header("Location: ../admin/rescatistas");
?>