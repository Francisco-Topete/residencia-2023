<?php 
    include '../sqlservercall.php'; 

    $arrayData = ['Usuario' => array()];

    $query = sqlsrv_query($conn, "EXEC dbo.ConsultarUsuarios"); 

    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
        array_push($arrayData['Usuario'], array
        (
            'Telefono' => $row['Telefono_Usuario'], 
            'Nombre' => $row['Nombre_Usuario'],
            'Apellido' => $row['Apellido_Usuario'],
            'Tipo_Usuario' => $row['Nombre_Tipo_Usuario']
        ));
    }

    echo json_encode($arrayData);
?>