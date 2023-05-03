<?php 

include 'sqlservercall.php'; 


$arrayEspecies = []; 
$query= sqlsrv_query($conn, "EXEC dbo.ConsultarEspecies"); 

while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
    array_push($arrayEspecies,$row['Nombre_Especie']);
}

echo json_encode($arrayEspecies);
?>