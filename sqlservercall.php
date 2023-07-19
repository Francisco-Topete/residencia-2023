<?php
//Este PHP unicamente se dedica a abrir la conexion a la base de datos de la plataforma web, y a nada mas.
//Si el servidor llegase a cambiar cualquier cosa, aqui se debe de reflejar esos cambios inmediatamente, o
//la aplicacion no se conectara a la tabla.

    $serverName = "164.92.90.165,4700"; //Este es el nombre y direccion IP del servidor en si.                                                      
    $uid = "sa"; //Este es el nombre de usuario del administrador que maneja la tabla del proyecto.
    $pwd = "b45!0f44P12D"; //Esta es su respectiva contraseña.
    $tabla = "Sistema_Censado_Animales";
    $habilitarSeguridad = true;

    //Aqui abajo creamos un arreglo donde asignaremos todos los datos que definimos arriba.
    //Este arreglo debe de ir asi por que es el formato de la cadena de SQL Server. 
    //Cualquier cambio a los datos de las variable se debe de modificar arriba.
    $connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database"=> $tabla, "Encrypt"=> $habilitarSeguridad,
                         "TrustServerCertificate" => $habilitarSeguridad);  
    

    $conn = sqlsrv_connect($serverName, $connectionInfo);  //Se ejecuta la conexion a la base de datos.