//Se definen los arreglos de los animales y los filtros.
var arrayAnimales = [], arrayFilters = [];

//Esta constante almacena TODOS los marcadores del mapa y sus datos.
const markerGroup = [];

//Esta función es la que genera todo el mapa.
function generateMap()
{	
    //Aqui esta el marcador de acceso unico de Mapbox.
	mapboxgl.accessToken = 'pk.eyJ1IjoibWFkYXJhYWxhbiIsImEiOiJjbGdqdzhzdXYwMHV4M2VxNXZiODV4c3VzIn0.doXQbG8IWzpjubw0hj1pDA';
        var map = new mapboxgl.Map
        ({
            container: 'map', //Se indica cual es el contenedor
            style: 'mapbox://styles/mapbox/streets-v11', //El estilo de mapbox a utilizar
            center: [-117.0574147,32.52611233], //En que latitud y longitud se centrara el mapa
            zoom: 14 //Que tanto zoom va a tener el mapa.
        });       
        
        //Esta función de aqui se encarga de la pantalla de carga del mapa.
        displayLoading();

        //Esta otra función es la encargada de llamar a los animales y colocar los marcadores.
        callAnimalAPI(map);
}

function displayLoading() 
{
    //Se habilita la pantalla de carga.
    loader.classList.add("display");
    loaderBackground.classList.add("display");

    //Se coloca un tiempo de carga de 10 segundos por defecto.
    setTimeout(() => {
        loader.classList.remove("display");
        loaderBackground.classList.remove("display");
    }, 10000);
}

//Esta función esconde la pantalla de carga prematuramente.
function hideLoading() 
{
    loader.classList.remove("display");
    loaderBackground.classList.remove("display");
}

function callAnimalAPI(map)
{
    //Por medio de AJAX, se accede a la API de los datos de los animales.
    fetch('api/apiAnimalData.php')
    .then((response) => 
    {

        if(!response.ok){ 
            throw new Error("No!");
        }

        return response.json(); 
    })
    .then((data) => 
    {
        //Se definen todos los indices a utilizar del arreglo de los animales.
        let arrayKeys = [], arrayInnerKeys = [], arrayLowerInnerKeys = [];
        
        //Se convierte la primera dimension del arreglo JSON a arreglo regular.
        arrayKeys = Object.keys(data);
        arrayKeys.forEach(key => 
        {
            arrayAnimales[key] = (data[key] == null ? "" : data[key]);
        });

        //Se convierte la segunda dimension del arreglo JSON a arreglo regular.
        arrayKeys = Object.keys(data['Animales']);
        arrayKeys.forEach(key => 
        {
            arrayAnimales['Animales'][key] = (data['Animales'][key] == null ? "" : data['Animales'][key]);
            arrayInnerKeys = Object.keys(arrayAnimales['Animales'][key]);
            
            //Se convierte la tercera dimension del arreglo JSON a arreglo regular.
            arrayInnerKeys.forEach(innerkey => 
            {                  
        arrayAnimales['Animales'][key][innerkey] = (data['Animales'][key][innerkey] == null ? "" : data['Animales'][key][innerkey]);
                
        if(innerkey == 'Heridas' || innerkey == 'Problemas_Salud')
                {
                    arrayLowerInnerKeys = Object.keys(arrayAnimales['Animales'][key][innerkey])
                    arrayLowerInnerKeys.forEach(lowerinnerkey => 
                    {
            arrayAnimales['Animales'][key][innerkey][lowerinnerkey] = (data['Animales'][key][innerkey][lowerinnerkey] == null ? "" : data['Animales'][key][innerkey][lowerinnerkey]);
        });
        }
            }); 
        });
                        
        console.log(arrayAnimales);

        //Se inicia el procedimiento de añadir los marcadores al mapa.
        anadirMarcadores(map); 
    }) 
}

function anadirMarcadores(map)
{
    //Esta variable es para almacenar el color de los marcadores del mapa.
    let markerColor = ""; 

    //Por cada animal que tengamos...
    arrayAnimales['Animales'].forEach(animal =>
    {
        //Definimos la longitud y la latitud.
        let longitud = animal['Longitud'];
        let latitud = animal['Latitud'];

        //Convertimos la foto que tenemos almacenada en Base64 en una imagen.
	    let foto =  new Image();
        foto.src = 'data:image/jpeg;base64,' + animal['Foto'];

        //Obtenemos un color aleatorio.
        markerColor = Math.floor(Math.random()*16777215).toString(16);

        //Creamos un objeto marcador.
        let marker = new mapboxgl.Marker
        ({
            anchor: "center", //Centramos sus elementos.
            color: "#" + markerColor //Agrefamos si color.				   
        })
        .setLngLat([longitud, latitud]) //Definimos su locación con latitud y longitud.
        .setPopup(new mapboxgl.Popup().setHTML //Colocamos el popup que va a contener todos los datos del animal.
        (
            //Aqui definimos el HTML de este popup. Notese que cada vez que saltas linea, se debe de
            //escapar la linea por medio de "\".
            "<div class='modal'>\
		 <img class='fotoAnimal' height=100px width=100px src='" + foto.src + "'>\
                 <h3> Especie: " + animal['Especie'] + "</h3>\
                 <h3> Raza: " + animal['Raza'] + "</h3>\
                 <h3> Situacion: " + animal['Situacion'] + "</h3>\
                 <h3> Edad: " + animal['Edad'] + "</h3>\
                 <h3> Comportamiento: " + animal['Agresividad'] + "</h3>\
                 <h3> Fecha de registro: " + animal['Fecha'] + "</h3>\
                 <h3> Hora de registro: " + animal['Hora'] + "</h3>\
             </div>"
        ))
        .addTo(map); //Finalmente, se añade el marcador al mapa.
        markerGroup[animal['ID']] = marker; //...Y se guarda en los marcadores que tenemos.
    });

    map.addControl(new mapboxgl.NavigationControl()); //Se añaden controles de navegación al mapa.
    hideLoading(); //Se esconde la pantalla de carga de forma prematura, si no han pasado 10 segundos.
}