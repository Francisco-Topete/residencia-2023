<?php 
//Esta API maneja el retiro de los datos de TODOS los usuario. Se utiliza para popular el ABC (Altas, Bajas,
//Consultas, Modificaciones) de la pagina web.

    //Se llama la conexión a la base de datos.
    include '../sqlservercall.php'; 

    $arrayData = ['Usuario' => array()];

    //Se consulta a todos los usuarios.
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

    //Se mandan todos los datos del usuario como un JSON Array.
    echo json_encode($arrayData);
?>