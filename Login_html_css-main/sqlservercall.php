<?php
//Este PHP unicamente se dedica a abrir la conexion a la base de datos de la plataforma web, y a nada mas.
//Si el servidor llegase a cambiar cualquier cosa, aqui se debe de reflejar esos cambios inmediatamente, o
//la aplicacion no se conectara a la tabla.

    $serverName = "201.170.169.54\\SQLEXPRESS, 1433"; //Este es el nombre y direccion IP del servidor en si.                                                      
    $uid = "Administrador"; //Este es el nombre de usuario del administrador que maneja la tabla del proyecto.
    $pwd = "12345678"; //Esta es su respectiva contraseña.
    $tabla = "Sistema_Censado_Animales";

    //Aqui abajo creamos un arreglo donde asignaremos todos los datos que definimos arriba.
    //Este arreglo debe de ir asi por que es el formato de la cadena de SQL Server. 
    //Cualquier cambio a los datos de las variable se debe de modificar arriba.
    $connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database"=> $tabla);  
    
    $conn = sqlsrv_connect( $serverName, $connectionInfo);  //Se ejecuta la conexion a la base de datos.
?>