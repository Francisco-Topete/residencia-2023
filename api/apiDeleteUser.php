<?php

include '../sqlservercall.php';

if (!empty($_POST['delete-telefono'])) //Si se reciben los datos del formulario en index, se hara lo siguiente:
{
    $data = array(
        "telefono" => $_POST['delete-telefono'],       
    );
}
else
{
    $json = file_get_contents('php://input');
    $data = json_decode($json,true);
}


$params = array($data['telefono']); 

$query= sqlsrv_query( $conn, "EXEC dbo.BorrarUsuario @Telefono = ?;",$params);
                    
$row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC); 
$POST = array("elemento"=>"borrado");
echo json_encode($POST);


header("Location: ../admin/rescatistas");
?>