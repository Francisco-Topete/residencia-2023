<?php
//Esta API es para eliminar usuarios de la aplicación.

//Se llama la conexión a la base de datos.
include '../sqlservercall.php';

if (!empty($_POST['delete-telefono'])) //Si se reciben los datos del formulario de la webapp, se asignan a un JSON:
{
    $data = array(
        "telefono" => $_POST['delete-telefono'],       
    );
}
else //Si se recibe de la aplicación movil, solo se recibe el JSON.
{
    $json = file_get_contents('php://input');
    $data = json_decode($json,true);
}

//Se realiza la eliminación del usuario.
$params = array($data['telefono']); 

$query= sqlsrv_query( $conn, "EXEC dbo.BorrarUsuario @Telefono = ?;",$params);
                    
$row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC); 
$POST = array("elemento"=>"borrado");
echo json_encode($POST);

//Redirige a la pantalla de administración.
header("Location: ../admin/rescatistas");
?>