<?php
$json = file_get_contents('php://input');
include 'sqlservercall.php';

/*$json = '{
    "telefono": "(664) 196-2477",
    "contrasena": "accesodirecto"
}';*/

$data = json_decode($json,true);

/*echo $data->telefono;
echo "\n";
echo $data->contrasena;*/

$params = array($data['telefono'],$data['contrasena']); 
$query= sqlsrv_query( $conn, "EXEC dbo.VerificarUsuario @Telefono_Usuario = ?, 
@Contrasena_Usuario = ?;",$params); 
                                    
$row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC); 
                                                                                                                    
if ($row['Telefono_Usuario'] && $row['Contrasena_Usuario']) 
{ 
    $POST = array("telefono"=>"Correcto",
    "contrasena"=>"Correcta");
    echo json_encode($POST);
} 
else 
{ 
    $POST = array("telefono"=>"Incorrecto",
    "contrasena"=>"Incorrecta");
    echo json_encode($POST); 
}    
?>