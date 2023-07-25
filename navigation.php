<?php
//En este PHP se incluye la barra de navegación que utilizan la mayoria de las paginas.

//Se incluye el archivo PHP que se encarga de manejar las sesiones. Toda pagina que ocupe sesión tiene
//barra de navegación, por eso se incluye aqui.
include 'sessionManager.php';


//Para desplegar el HTML en PHP, se le hace echo directamente.

//Contenedor de barra de navegación
echo "<nav>";
echo "<div class=\"navbar\">";
echo "<div class=\"container nav-container\">";
//Checkbox invisible encargada de desplegar y esconder el menu de hamburguesa
echo "<input class=\"checkbox\" type=\"checkbox\" name=\"\" id=\"\" />";
//Icono de menu de hamburguesa
echo "<div class=\"hamburger-lines\">";
echo "<span class=\"line line1\"></span>";
echo "<span class=\"line line2\"></span>";
echo "<span class=\"line line3\"></span>";
echo "</div>";  
//Contenedor del titulo
echo "<div class=\"logo\">";
echo "<h1>Censo Animales BC</h1>";
echo "</div>";
//Menu con items de navegación.
echo "<div class=\"menu-items\">";
echo "<li><a href=\"../home\">Ver Mapa</a></li>"; //Pantalla del mapa

//Si el usuario es administrador o coordinador, se le dara acceso a la pantalla 
//del ABC (Altas, Bajas, Consultas y Modificaciones de usuarios). Si es rescatista
//esta opción no aparecera en el menú
if($_SESSION['user-type'] == 'Administrador' || $_SESSION['user-type'] == 'Coordinador')
{
    echo "<li><a href=\"admin/rescatistas\">Administrar rescatistas/moderadores</a></li>";  
}

echo "<li><a href=\"../logout\">Cerrar sesion</a></li>"; //Elemento para cerrar sesión de la cuenta.
echo "</div>";
echo "</div>";
echo "</div>";
echo "</nav>";
?>