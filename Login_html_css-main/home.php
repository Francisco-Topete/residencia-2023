<!DOCTYPE html>
<html lang="es">
<head>
<!-- mapboxs-->
<script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
<!--mapboxs-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MAPA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/burgerMenu.css">
</head>

<body>
    <!-- clase contenedor para el maps-->
<?php
include 'navigation.php';
?>

<div class="contenedorHome">

         <!-- insercion del maps -->
    <div class="contenedorMapa">
        <div id="map"></div>
        <script>
            mapboxgl.accessToken = 'pk.eyJ1IjoibWFkYXJhYWxhbiIsImEiOiJjbGdqdzhzdXYwMHV4M2VxNXZiODV4c3VzIn0.doXQbG8IWzpjubw0hj1pDA';
            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v10'
            });

            map.addControl(new mapboxgl.NavigationControl());
            map.setView([32.3604400, -117.0464500], 7);
        </script>

    </div>

     <!-- division para los filtros-->
    <form class="Filtros">          
        <div class="texto-Filtros">
             <!-- filtro para la especie -->
            <label>Especie</label> <br>
            <select class="select-box">
                <option value="">Elige una opcion</option>
                <option value="">Perro</option>
                <option value="">Gato</option>
                <option value="">Otro</option> 
            </select><br>

            <!-- filtro para la raza -->
            <label>Raza</label> <br>
            <select class="select-box">
            <option value="">Elige una opcion</option>
                <option value="">huky </option>
                <option value="">pitbull</option>
                <option value="">labrador</option>
            </select><br>

            <!-- filtro para el sexo -->
            <label>Sexo</label> <br>
            <select class="select-box">
            <option value="">Elige una opcion</option>
                <option value="">Macho </option>
                <option value="">Hembra</option>
            </select><br>

            <!-- filtro para la situacion -->
            <label>Situacion</label> <br>
            <select class="select-box">
            <option value="">Elige una opcion</option>
                <option value="">callejero </option>
                <option value="">hogar</option>
            </select><br>
            
            <!-- filtro para la edad -->
            <label>Edad</label> <br>
            <select class="select-box">
            <option value="">Elige una opcion</option>
                <option value="">cachorro lactante </option>
                <option value="">cachorro destetado</option>
                <option value="">Adolescente</option>
                <option value="">Adulto</option>
                <option value="">Anciano</option>
            </select><br>
            
            <!-- filtro para la salud -->
            <label>Problemas de salud</label> <br>
            <select class="select-box">
            <option value="">Elige una opcion</option>
                <option value="">Sarna</option>
                <option value="">Garrapatas</option>
                <option value="">Pulgas</option>
                <option value="">Sange en heces/orina</option>
                <option value="">Diarrea</option>
                <option value="">Vomito</option>
                <option value="">Rabia</option>
                <option value="">Alergias</option>
                <option value="">Heridas infectadas</option>
                <option value="">infeccion en ojos</option>
                <option value="">moquillo</option>
                <option value="">Parvo virus</option>
                <option value="">Otro</option>
            </select><br>
            
            <!-- filtro para la desnutricion -->
            <label>Desnutricion</label> <br>
            <select class="select-box">
            <option value="">Elige una opcion</option>
                <option value="">Si </option>
                <option value="">No</option>
            </select><br>

            <!-- filtro para las heridas -->
            <label>Heridas</label> <br>
            <select class="select-box">
            <option value="">Elige una opcion</option>
                <option value="">Signos de maltrato </option>
                <option value="">Atropellado</option>
                <option value="">Patas lecionadas</option>
                <option value="">laceraciones</option>
                <option value="">Mordidas</option>
                <option value="">Rasguños</option>
                <option value="">Contuciones</option>
                <option value="">Otros</option>
            </select><br>

            <!-- filtro para el comportamiento -->
            <label>Comportamiento</label> <br>
            <select class="select-box">
            <option value="">Elige una opcion</option>
                <option value="">Docil</option>
                <option value="">Agresivo</option>
                <option value="">Miedo</option>
            </select><br>      
        </div>       
    </form>
</div>
</body>
</html>
