<?php

include '../sqlservercall.php';

if (!empty($_POST['telefono_old'])) //Si se reciben los datos del formulario en index, se hara lo siguiente:
{
    $data = array(
        "telefono_old" => $_POST['telefono_old'],
        "telefono" => $_POST['telefono'],
        "nombre" => $_POST['nombre'],
        "apellido" => $_POST['apellido'],
        "tipo_usuario" => $_POST['tipo_usuario'],
        "contrasena_old" => $_POST['contrasena_old'],
        "contrasena_new" => $_POST['contrasena_new'],
    );
}
else
{
    $json = file_get_contents('php://input');
    $data = json_decode($json,true);
}

$modify = false;

if($data['contrasena_old'] != "")
{
    $params = array($data['telefono_old'],$data['contrasena_old']); 
    $query= sqlsrv_query( $conn, "EXEC dbo.VerificarUsuario @Telefono_Usuario = ?, 
    @Contrasena_Usuario = ?;",$params); 
                                        
    $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC); 
                                                                                                                        
    if ($row['Telefono_Usuario'] && $row['Contrasena_Usuario']) 
    { 
        $modify = true;
    } 

    if($modify)
    {
        $paramsModify = array($data['telefono'], $data['nombre'], $data['apellido'], 
                            $data['contrasena_new'], $data['tipo_usuario'], $data['telefono_old']); 

        $query= sqlsrv_query( $conn, "EXEC dbo.ModificarUsuario @Telefono = ?, 
                            @Nombre = ?, @Apellido = ?, @Contrasena_Usuario = ?, @Tipo = ?,
                            @Telefono_Original = ?;",$paramsModify);
                            
        $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC); 

        $POST = array("modificacion"=>"aceptada");
        echo json_encode($POST);
    }
    else
    {
        $POST = array("modificacion"=>"rechazada");
        echo json_encode($POST);
    }
}
else
{
    $params = array($data['telefono_old']); 
    $query = sqlsrv_query( $conn, "EXEC dbo.VerificarTelefono @Telefono = ?;",$params); 
                                        
    $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC); 
                                                                                                                        
    if ($row['Telefono_Usuario']) 
    { 
        $modify = true;
    }   

    if($modify)
    {
        $paramsModify = array($data['telefono'], $data['nombre'], $data['apellido'], 
                            $data['tipo_usuario'], $data['telefono_old']); 

        $query= sqlsrv_query( $conn, "EXEC dbo.ModificarUsuarioSinContrasena @Telefono = ?, 
                            @Nombre = ?, @Apellido = ?, @Tipo = ?, 
                            @Telefono_Original = ?;",$paramsModify);
                            
        $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC); 

        $POST = array("modificacion"=>"aceptada");
        echo json_encode($POST);
    }
    else
    {
        $POST = array("modificacion"=>"rechazada");
        echo json_encode($POST);
    }
}

header("Location: ../admin/rescatistas");
?>