<?php 
//Esta API es para retirar las opciones de los select de la pantalla del menu de la webapp y para el formulario
//de captura de la aplicación movil.

//Se llama la conexión a la base de datos.
include '../sqlservercall.php'; 

//Se define el arreglo que almacenara las opciones de los select.
$arrayData = ['Especies' => array(), 
              'Razas' => array(),
              'Situacion' => array(),
              'Edad' => array(),
              'Problemas_Salud' => array(),
              'Heridas' => array(),
              'Comportamiento' => array()];

//Aqui se inicia el procedimiento de consulta de las opciones del select.

//Esto es para las especies.
$query = sqlsrv_query($conn, "EXEC dbo.ConsultarEspecies"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    array_push($arrayData['Especies'], array
    (
        'ID' => $row['ID_Especie'], 
        'Nombre' => $row['Nombre_Especie']
    ));
}

//Esto es para las razas.
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

//Esto es para las situaciones.
$query = sqlsrv_query($conn, "EXEC dbo.ConsultarSituacion"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    array_push($arrayData['Situacion'], array
    (
        'ID' => $row['ID_Situacion'], 
        'Nombre' => $row['Nombre_Situacion']
    ));
}

//Esto es para las edades.
$query = sqlsrv_query($conn, "EXEC dbo.ConsultarEdad"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    array_push($arrayData['Edad'], array
    (
        'ID' => $row['ID_Edad'], 
        'Nombre' => $row['Nombre_Edad']
    ));
}

//Esto es para los problemas de salud.
$query = sqlsrv_query($conn, "EXEC dbo.ConsultarProblema_Salud"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    array_push($arrayData['Problemas_Salud'], array
    (
        'ID' => $row['ID_Problema_Salud'], 
        'Nombre' => $row['Nombre_Problema_Salud']
    ));
}

//Esto es para las heridas.
$query = sqlsrv_query($conn, "EXEC dbo.ConsultarHeridas"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    array_push($arrayData['Heridas'], array
    (
        'ID' => $row['ID_Herida'], 
        'Nombre' => $row['Nombre_Herida']
    ));
}

//Esto es para los comportamientos.
$query = sqlsrv_query($conn, "EXEC dbo.ConsultarAgresividad"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    array_push($arrayData['Comportamiento'], array
    (
        'ID' => $row['ID_Agresividad'], 
        'Nombre' => $row['Nombre_Agresividad']
    ));
}

//Finalmente, se codifica como un JSON Array. 
//Es importante dar a notar que indicamos a el codificador que ignore caracteres que no son UTF-8, para
//evitar problemas con la consulta.
$jsonArray = json_encode($arrayData, JSON_INVALID_UTF8_IGNORE);
echo $jsonArray;
?>