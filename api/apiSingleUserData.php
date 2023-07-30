<?php 
//Esta API maneja el retiro de los datos de un solo usuario. Se utiliza para popular el formulario de
//modificación.

    //Se espera la llamada de AJAX.
    $json = file_get_contents('php://input', true);

    //Se llama la conexión a la base de datos.
    include '../sqlservercall.php'; 

    //Se decodifica el JSON del usuario recibido.
    $data = json_decode($json,true);
    $arrayData = array();
    $params = array($data['telefono']); 

    //Se busca al usuario.
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

    //Se envian los datos por medio de un JSON Array.
    echo json_encode($arrayData);
?>