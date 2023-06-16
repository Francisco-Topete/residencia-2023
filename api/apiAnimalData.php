<?php 
include '../sqlservercall.php'; 

$arrayData = ['Animales' => array()];
$params = array();
$numAnimal = 0;

$query = sqlsrv_query($conn, "EXEC dbo.ConsultarAnimales"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    array_push($arrayData['Animales'], array
    (
        'ID' => $row['ID_Animal'], 	
        'Foto' => $row['Foto_Animal'],
        'Especie' => $row['Nombre_Especie'],
        'Raza' => $row['Nombre_Raza'],
        'Situacion' => $row['Nombre_Situacion'],
        'Edad' => $row['Nombre_Edad'],
	'Heridas' => array(),
	'Problemas_Salud' => array(),
        'Agresividad' => $row['Nombre_Agresividad'],
        'Latitud' => $row['Locacion_Latitud_Animal'],
        'Longitud' => $row['Locacion_Longitud_Animal'],
        'Fecha' => $row['Fecha_Registro'],
        'Hora' => $row['Hora_Registro'],
    ));

    array_push($params,$row['ID_Animal']);
}

foreach($params as $id)
{
    $query = sqlsrv_query($conn, "EXEC dbo.ConsultarHeridasAnimal @ID_Animal = " . $id . ";"); 
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
        array_push($arrayData['Animales'][$numAnimal]['Heridas'], array
        (
            'Nombre' => $row['Nombre_Herida'],		
        ));
    }

    $query = sqlsrv_query($conn, "EXEC dbo.ConsultarProblemas_SaludAnimal @ID_Animal = " . $id . ";"); 
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
        array_push($arrayData['Animales'][$numAnimal]['Problemas_Salud'], array
        (
            'Nombre' => $row['Nombre_Problema_Salud'],
        ));
    }

    $numAnimal++;
}

echo json_encode($arrayData);
?>