<?php 
    $json = file_get_contents('php://input', true);
    include '../sqlservercall.php'; 

    $data = json_decode($json,true);
    $arrayData = array();
    $params = array($data['telefono']); 
    $query = sqlsrv_query($conn, "EXEC dbo.ConsultarUsuario @Telefono = ?",$params); 
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
        array_push($arrayData, array
        (
            'Telefono' => $row['Telefono_Usuario'], 
            'Nombre' => $row['Nombre_Usuario'],
            'Apellido' => $row['Apellido_Usuario'],
            'Tipo_Usuario' => $row['Nombre_Tipo_Usuario']
        ));
    }

    echo json_encode($arrayData);
?>