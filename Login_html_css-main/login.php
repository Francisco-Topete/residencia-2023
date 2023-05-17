<?php
//Esta pagina es la que verifica los datos introducidos en index.php, para verificar que el usuario
//Ya este registrado.

    session_start(); //Abrimos sesion de PHP, para almacenar datos necesarios del 
                    //usuario en el navegador web en caso de que el inicio de sesion se verifique.

    include 'sqlservercall.php'; //Llamamos este archivo PHP para abrir la conexion a la base de datos.
                                 //Cualquier cambio a la base de datos debe verse reflejado en ese archivo.

    if (isset($_POST['ingresar'])) //Si se reciben los datos del formulario en index, se hara lo siguiente:
    { 
        //Se definen los datos del usuario en base al formulario.
        $telefono = $_POST['usuario']; //Telefono
        $contrasena = $_POST['contrasena']; //Contraseña
        $params = array($telefono,$contrasena); //Se crea un arreglo con estos 2 datos.
        $query= sqlsrv_query( $conn, "EXEC dbo.VerificarUsuario @Telefono_Usuario = ?, 
        @Contrasena_Usuario = ?;",$params); //Se hace una consulta al servidor de SQL por medio de un
                                            //procedimiento, tomando como variables los parametros asignados en base al formulario.

        if ($query=== false) //Si no llegara a encontrarse nada...
        { 

            echo '<p class="error">Estas mal!</p>'; //Error

        } 
        else //Si se llega a encontrar algo que coincida
        { 

            $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC); //Vamos a jalar el primer renglon de la
                                                                   //consulta, que solo deberia ser uno, como
                                                                   //un arreglo.
            if ($row['Contrasena_Usuario']) //Si en lo que recorremos el arreglo llegamos a la columna de la contrasena...
            { 
                $_SESSION['user_id'] = $query['Telefono_Usuario']; //Tomaremos el telefono como dato de la sesion.
                header('Location: '.'home.php'); //Entraremos a la plataforma web con una redireccion...
                die(); //y mataremos este PHP.

            } 
            else //Si no...
            { 
                header('Location: /'); //Volveremos a la pantalla de inicio de sesion.
            }
        }
    }   
?>
