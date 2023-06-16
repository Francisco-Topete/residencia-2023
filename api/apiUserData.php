<?php 
include '../sqlservercall.php'; 

$arrayData = [];

$query = sqlsrv_query($conn, "EXEC dbo.ConsultarUsuarios"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    array_push($arrayData[], array
    (
        'ID' => $row['ID_Especie'], 
        'Nombre' => $row['Nombre_Especie']
    ));
}

$query = sqlsrv_query($conn, "EXEC dbo.ConsultarRazas"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    array_push($arrayData['Razas'], array
    (
        'ID' => $row['ID_Raza'], 
        'Nombre' => $row['Nombre_Raza'],
        'Especie' => $row['Especie_Raza']
    ));
}

$query = sqlsrv_query($conn, "EXEC dbo.ConsultarSituacion"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    array_push($arrayData['Situacion'], array
    (
        'ID' => $row['ID_Situacion'], 
        'Nombre' => $row['Nombre_Situacion']
    ));
}

$query = sqlsrv_query($conn, "EXEC dbo.ConsultarEdad"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    array_push($arrayData['Edad'], array
    (
        'ID' => $row['ID_Edad'], 
        'Nombre' => $row['Nombre_Edad']
    ));
}

$query = sqlsrv_query($conn, "EXEC dbo.ConsultarProblema_Salud"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    array_push($arrayData['Problemas_Salud'], array
    (
        'ID' => $row['ID_Problema_Salud'], 
        'Nombre' => $row['Nombre_Problema_Salud']
    ));
}

$query = sqlsrv_query($conn, "EXEC dbo.ConsultarHeridas"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    array_push($arrayData['Heridas'], array
    (
        'ID' => $row['ID_Herida'], 
        'Nombre' => $row['Nombre_Herida']
    ));
}

$query = sqlsrv_query($conn, "EXEC dbo.ConsultarAgresividad"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    array_push($arrayData['Comportamiento'], array
    (
        'ID' => $row['ID_Agresividad'], 
        'Nombre' => $row['Nombre_Agresividad']
    ));
}

echo json_encode($arrayData);
?>