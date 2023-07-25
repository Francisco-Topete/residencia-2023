<!DOCTYPE html>
<html lang="es">   
<head>
    <!-- Librerias de Mapbox-->
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
    <!-- Librerias de Mapbox -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mapa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilosHome.css">
    <link rel="stylesheet" href="css/burgerMenu.css">
    <link rel="stylesheet" href="css/modalMapMarker.css">

    <!-- Javascript que se encarga de todas las funciones relacionadas con la carga del mapa (Nodos)-->
    <script src="js/mainMap.js"></script>      
</head>


<body>
    <!-- PHP de la barra de navegación + el manager de sesiones-->
    <?php
        include 'navigation.php';
    ?>

    <!-- Contenedor principal del mapa -->
    <div class ="contenedorMapa"> 
        <!-- HTML donde se va a insertar el mapa -->
        <div id="map">
            <!-- Contenedor que se utilizara para contener y centrar la barra de carga -->
            <div id="loadingBackground">
                <!-- Barra de carga del mapa (Circulo) -->
                <div id="loading"></div>
            </div>
        </div>
        <script>
            var userType = <?php echo "'" . $_SESSION['user-type'] . "'";?>;    //Se manda el tipo de usuario
                                                                                //Que tiene sesion iniciada
                                                                                //Al Javascript, para 
                                                                                //identificar si es adminis-
                                                                                //trador o coordinador, para
                                                                                //La edición y eliminación 
                                                                                //De nodos.
            
            const loader = document.querySelector("#loading");  //Se agarra la barra de carga para su activación
                                                                //Y desactivación en el Javascript.

            const loaderBackground = document.querySelector("#loadingBackground");  //Lo mismo con su
                                                                                    //contenedor.
                                                                                    
            generateMap();  //Esta es la función que se encarga de generar el mapa con todos sus nodos.							     
        </script>
    </div>

    <!-- Este es el contenedor que sirve como boton para mostrar y esconder los filtros. -->
    <div class="switchFiltros" id="switchFiltros">
        +
    </div>

    <!-- Este es el contenedor que contiene el formulario con todos los filtros. -->
    <div class="contenedorFiltros" id="contenedorFiltros">                                   
        <form class="Filtros" id="formFiltros" action="" method="get">
            <div class="texto-Filtros">
            <!-- filtro para la especie -->
                <label>Especie</label> <br>
                <select id="selectEspecie" name="especie" class="select-box">
                    <option value="" hidden>Elige una opcion</option>
                </select><br>
                
                <!-- filtro para la raza -->
                <label>Raza</label> <br>
                <select id="selectRaza" name="raza" class="select-box">
                    <option value="" hidden>Elige una opcion</option>

                    <!-- Opciones estan en el javascript-->

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

<!-- Javascript para otras funciones miscelaneas del cuerpo (importar opciones del filtrado de la BD, GET
 para los filtros, etc.) -->
<script src="js/mainHome.js"></script>     
</body>
</html>
