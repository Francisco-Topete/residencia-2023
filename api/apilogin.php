<?php
//Esta API maneja los inicios de sesion de la aplicación movil.

//Se desactivan los errores y advertencias del PHP para que no interfieran con el JSON.
error_reporting(0);

//Se llama la conexión a la base de datos.
include '../sqlservercall.php';

//Se recibe los datos de la petición.
$json = file_get_contents('php://input');
$data = json_decode($json,true);

/*echo $data->telefono;
echo "\n";
echo $data->contrasena;*/

//Se verifica el usuario.
$params = array($data['telefono'],$data['contrasena']); 
$query= sqlsrv_query( $conn, "EXEC dbo.VerificarUsuario @Telefono_Usuario = ?, 
@Contrasena_Usuario = ?;",$params); 
                                    
$row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC); 
                        
//Si el usuario pasa la verificación sin problemas, manda una señal positiva a la aplicación.
if ($row['Telefono_Usuario'] && $row['Contrasena_Usuario']) 
{ 
    $POST = array("telefono"=>"Correcto",
    "contrasena"=>"Correcta");
    echo json_encode($POST);
} 
else  //Si no, deniega el acceso.
{ 
    $POST = array("telefono"=>"Incorrecto",
    "contrasena"=>"Incorrecta");
    echo json_encode($POST); 
}    
?>