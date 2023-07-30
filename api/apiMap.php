<?php
//Esta API maneja los registros de nodos al mapa desde la aplicación movil.

//Recibe la petición de la aplicación movil.
$json = file_get_contents('php://input');

//Se llama la conexión a la base de datos.
include '../sqlservercall.php';

//Se decodifica el JSOn a un arreglo regular y se divide en parametros.
$data = json_decode($json,true);
$params = array($data['fotografia'],$data['especie'],$data['raza'],$data['situacion'],$data['edad'],
$data['problemas_salud'],$data['heridas'],$data['comportamiento'],$data['locacion_latitud'],$data['locacion_longitud'],
$data['fecha_registro'],$data['hora_registro']); 

//Se realiza la consulta con dichos parametros.
$query= sqlsrv_query( $conn, "EXEC dbo.RegistrarAnimalMapa @ID_Animal = 0, @Foto = ?, 
@Especie = ?, @Raza = ?, @Situacion = ?, @Edad = ?, @Problema_Salud = ?,
@Herida = ?, @Agresividad = ?, @Latitud = ?, @Longitud = ?, @Fecha = ?, @Hora = ?;",$params);     
?>