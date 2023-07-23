<?php
$json = file_get_contents('php://input');
include '../sqlservercall.php';

$data = json_decode($json,true);
$params = array($data['fotografia'],$data['especie'],$data['raza'],$data['situacion'],$data['edad'],
$data['problemas_salud'],$data['heridas'],$data['comportamiento'],$data['locacion_latitud'],$data['locacion_longitud'],
$data['fecha_registro'],$data['hora_registro']); 

$query= sqlsrv_query( $conn, "EXEC dbo.RegistrarAnimalMapa @ID_Animal = 0, @Foto = ?, 
@Especie = ?, @Raza = ?, @Situacion = ?, @Edad = ?, @Problema_Salud = ?,
@Herida = ?, @Agresividad = ?, @Latitud = ?, @Longitud = ?, @Fecha = ?, @Hora = ?;",$params);     
?>