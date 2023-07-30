<?php
//Esta API maneja las modificaciones de los usuarios.

//Se llama la conexión a la base de datos.
include '../sqlservercall.php';

if (!empty($_POST['telefono_old'])) //Si se reciben los datos del formulario de la webapp, se asignan a un JSON:
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
else //Si se recibe de la aplicación movil, solo se recibe el JSON.
{
    $json = file_get_contents('php://input');
    $data = json_decode($json,true);
}

//Se crea una bandera para confirmar o prohibir la modificación del usuario.
$modify = false;

//Si se otorgo una contraseña para modificarla, se sigue este camino, donde se verifica tanto el usuario como
//la contraseña.
if($data['contrasena_old'] != "")
{
    $params = array($data['telefono_old'],$data['contrasena_old']); 
    
    //Se verifica el usuario y la contraseña.
    $query= sqlsrv_query( $conn, "EXEC dbo.VerificarUsuario @Telefono_Usuario = ?, 
    @Contrasena_Usuario = ?;",$params); 
                                        
    $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC); 
                                                                                                                        
    if ($row['Telefono_Usuario'] && $row['Contrasena_Usuario']) //Si ambos coindicen, se da el visto 
    {                                                           //bueno para modificar.
        $modify = true;
    } 

    //Si la bandera esta en verdadero, entonces se realiza la modificación con los datos otorgados.
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
    else //Sino, no se realiza ningun cambio.
    {
        $POST = array("modificacion"=>"rechazada");
        echo json_encode($POST);
    }
}
else
{
    $params = array($data['telefono_old']); 

    //Se verifica unicamente que exista el usuario en la base de datos.
    $query = sqlsrv_query( $conn, "EXEC dbo.VerificarTelefono @Telefono = ?;",$params); 
                                        
    $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC); 
                                                                                                                        
    if ($row['Telefono_Usuario']) //Si existe, se da el visto bueno para la modificación.
    { 
        $modify = true;
    }   

    //Si la bandera esta en verdadero, entonces se realiza la modificación con los datos otorgados.
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
    else //Sino, no se realiza ningun cambio.
    {
        $POST = array("modificacion"=>"rechazada");
        echo json_encode($POST);
    }
}

//Redirige a la pantalla de administración.
header("Location: ../admin/rescatistas");
?>