
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MAPA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .contenedor{
            height: 50vh;
            margin: 5%;
            display: flex ;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
        }
    </style>
    
</head>

<body>
    
    <div class="contenedor">
<div id="mapa">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d107847.06430162302!2d-117.12744315223034!3d32.3596229541357!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80d9313f72cece1b%3A0x7a0ec61c8d78d247!2sRosarito%2C%20B.C.!5e0!3m2!1ses!2smx!4v1678830340019!5m2!1ses!2smx" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
        <form class="Filtros">
            <div class="texto-Filtros">

                <label>Especie</label> <br>
                <select name="" id="">
                    <option value="">Perro </option>
                    <option value="">Gato</option>
                    <option value="">Otro</option> 
                </select><br>

                <label>Raza</label> <br>
                <select name="" id="">
                    <option value="">huky </option>
                    <option value="">pitbull</option>
                    <option value="">labrador</option>
                </select><br>

                <label>Sexo</label> <br>
                <select name="" id="">
                    <option value="">Macho </option>
                    <option value="">Hembra</option>
                </select><br>

                <label>Situacion</label> <br>
                <select name="" id="">
                    <option value="">callejero </option>
                    <option value="">hogar</option>
                </select><br>

                <label>Edad</label> <br>
                <select name="" id="">
                    <option value="">cachorro lactante </option>
                    <option value="">cachorro destetado</option>
                    <option value="">Adolescente</option>
                    <option value="">Adulto</option>
                    <option value="">Anciano</option>
                </select><br>

                <label>Problemas de salud</label> <br>
                <select name="" id="">
                    <option value="">Sarna</option>
                    <option value="">Garrapatas</option>
                    <option value="">Pulgas</option>
                    <option value="">Sange en heces/orina</option>
                    <option value="">Diarrea</option>
                    <option value="">Vomito</option>
                    <option value="">Rabia</option>
                    <option value="">Alergias</option>
                    <option value="">Heridas infectadas/option>
                    <option value="">infeccion en ojos</option>
                    <option value="">moquillo</option>
                    <option value="">Parvo virus</option>
                    <option value="">Otro</option>
                </select><br>

                <label>Desnutricion</label> <br>
                <select name="" id="">
                    <option value="">Si </option>
                    <option value="">No</option>
                </select><br>

                <label>Heridas</label> <br>
                <select name="" id="">
                    <option value="">Signos de maltrato </option>
                    <option value="">Atropellado</option>
                    <option value="">Patas lecionadas</option>
                    <option value="">laceraciones</option>
                    <option value="">Mordidas</option>
                    <option value="">Rasguños</option>
                    <option value="">Contuciones</option>
                    <option value="">Otros</option>
                </select><br>

                <label>Comportamiento</label> <br>
                <select name="" id="">
                    <option value="">Docil</option>
                    <option value="">Agresivo</option>
                    <option value="">Miedo</option>
                </select><br>
                
            </div>
            
        </form>
    </div>
<?php echo "Si" ?>
</body>

</html>
