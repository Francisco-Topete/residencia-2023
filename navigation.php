<?php
include 'sessionManager.php';

echo "<nav>";
echo "<div class=\"navbar\">";
echo "<div class=\"container nav-container\">";
echo "<input class=\"checkbox\" type=\"checkbox\" name=\"\" id=\"\" />";
echo "<div class=\"hamburger-lines\">";
echo "<span class=\"line line1\"></span>";
echo "<span class=\"line line2\"></span>";
echo "<span class=\"line line3\"></span>";
echo "</div>";  
echo "<div class=\"logo\">";
echo "<h1>Censo Animales BC</h1>";
echo "</div>";
echo "<div class=\"menu-items\">";
echo "<li><a href=\"../home\">Ver Mapa</a></li>";

if($_SESSION['user-type'] == 'Administrador' || $_SESSION['user-type'] == 'Coordinador')
{
    echo "<li><a href=\"admin/rescatistas\">Administrar rescatistas/moderadores</a></li>";  
}

echo "<li><a href=\"../logout\">Cerrar sesion</a></li>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</nav>";
?>