<?php 

include 'sqlservercall.php'; 

$arrayData = ['Data' => array('Especies' => array(),'Razas' => array(), 
'Situacion' => array(), 'Edad' => array(), 'Problema_Salud' => array(),
'Heridas' => array(), 'Comportamiento' => array())];

$query = sqlsrv_query($conn, "EXEC dbo.ConsultarEspecies"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    $arrayData['Data']['Especies'][$row['ID_Especie']] = $row['Nombre_Especie'];
    $arrayData['Data']['Razas'][$row['Nombre_Especie']] = array();
}

$query = sqlsrv_query($conn, "EXEC dbo.ConsultarRazasPerros"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    $arrayData['Data']['Razas']['Perro'][$row['ID_Raza']] = $row['Nombre_Raza'];
}

$query = sqlsrv_query($conn, "EXEC dbo.ConsultarRazasGatos"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    $arrayData['Data']['Razas']['Gato'][$row['ID_Raza']] = $row['Nombre_Raza'];
}

array_push($arrayData['Data']['Razas']['Cuyo'],"-");
array_push($arrayData['Data']['Razas']['Otro'],"-");

$query = sqlsrv_query($conn, "EXEC dbo.ConsultarSituacion"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    $arrayData['Data']['Situacion'][$row['ID_Situacion']] = $row['Nombre_Situacion'];
}

$query = sqlsrv_query($conn, "EXEC dbo.ConsultarEdad"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    $arrayData['Data']['Edad'][$row['ID_Edad']] = $row['Nombre_Edad'];
}

$query = sqlsrv_query($conn, "EXEC dbo.ConsultarProblema_Salud"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    $arrayData['Data']['Problema_Salud'][$row['ID_Problema_Salud']] = $row['Nombre_Problema_Salud'];
}

$query = sqlsrv_query($conn, "EXEC dbo.ConsultarHeridas"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    $arrayData['Data']['Heridas'][$row['ID_Herida']] = $row['Nombre_Herida'];
}

$query = sqlsrv_query($conn, "EXEC dbo.ConsultarAgresividad"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    $arrayData['Data']['Comportamiento'][$row['ID_Agresividad']] = $row['Nombre_Agresividad'];
}

echo json_encode($arrayData, JSON_FORCE_OBJECT);
?>