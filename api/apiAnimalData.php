<?php 
//Esta API es para retirar los datos de TODOS los animales. En particular se usa para colocar los nodos en 
//el mapa.

//Se llama la conexión a la base de datos.
include '../sqlservercall.php'; 

//Se define el arreglo que almacenara a los animales.
$arrayData = ['Animales' => array()];

//Este arreglo de parametros se enfocara en sacar unicamente el ID del animal. Esto sera para un prodecimien-
//to mas adelante. El arreglo de Animales principal tambien tiene el ID del animal.
$params = array();

//Contador manual para un foreach mas adelante.
$numAnimal = 0;

//Aqui se inicia el procedimiento de consulta de animales.
$query = sqlsrv_query($conn, "EXEC dbo.ConsultarAnimales"); 
while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    //Cuando encuentre un animal con el procedimiento, lo empujara al arreglo. Notese que las heridas y los
    //Problemas de salud tienen su propio arreglo. Esto es para futuras actualizaciones, donde se decida que
    //los animales deban de tener mas de una herida o problema de salud.

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

    //ID almacenado en params
    array_push($params,$row['ID_Animal']);
}


//Se inicia el foreach de params. Este foreach es para extraer todos los problemas de salud y heridas de cada
//animal individual.

foreach($params as $id)
{

    //Consulta para las heridas.
    $query = sqlsrv_query($conn, "EXEC dbo.ConsultarHeridasAnimal @ID_Animal = " . $id . ";"); 
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
        array_push($arrayData['Animales'][$numAnimal]['Heridas'], array
        (
            'Nombre' => $row['Nombre_Herida'],		
        ));
    }

    //Consulta para los problemas de salud.
    $query = sqlsrv_query($conn, "EXEC dbo.ConsultarProblemas_SaludAnimal @ID_Animal = " . $id . ";"); 
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
        array_push($arrayData['Animales'][$numAnimal]['Problemas_Salud'], array
        (
            'Nombre' => $row['Nombre_Problema_Salud'],
        ));
    }

    //Contador manual para el ciclo, dado a que es un foreach.
    $numAnimal++;
}

//Finalmente, se codifica como un JSON Array. 
//Es importante dar a notar que indicamos a el codificador que ignore caracteres que no son UTF-8, para
//evitar problemas con la consulta.
echo json_encode($arrayData, JSON_INVALID_UTF8_IGNORE);
?>