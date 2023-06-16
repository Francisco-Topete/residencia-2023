var arrayAnimales = [], arrayFilters = [];
const markerGroup = [];

function generateMap()
{	
	mapboxgl.accessToken = 'pk.eyJ1IjoibWFkYXJhYWxhbiIsImEiOiJjbGdqdzhzdXYwMHV4M2VxNXZiODV4c3VzIn0.doXQbG8IWzpjubw0hj1pDA';
        var map = new mapboxgl.Map
        ({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [-117.0574147,32.52611233], 
            zoom: 14
        });        
        displayLoading();
        callAnimalAPI(map);
}

function displayLoading() 
{
    loader.classList.add("display");
    loaderBackground.classList.add("display");
    setTimeout(() => {
        loader.classList.remove("display");
        loaderBackground.classList.remove("display");
    }, 10000);
}

function hideLoading() 
{
    loader.classList.remove("display");
    loaderBackground.classList.remove("display");
}

function callAnimalAPI(map)
{
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
        let arrayKeys = [], arrayInnerKeys = [], arrayLowerInnerKeys = [];
        
        arrayKeys = Object.keys(data);
        arrayKeys.forEach(key => 
        {
            arrayAnimales[key] = (data[key] == null ? "" : data[key]);
        });

        arrayKeys = Object.keys(data['Animales']);
        arrayKeys.forEach(key => 
        {
            arrayAnimales['Animales'][key] = (data['Animales'][key] == null ? "" : data['Animales'][key]);
            arrayInnerKeys = Object.keys(arrayAnimales['Animales'][key]);
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
        anadirMarcadores(map); 
    }) 
}

function anadirMarcadores(map)
{
    let markerColor = ""; 

    arrayAnimales['Animales'].forEach(animal =>
    {
        let longitud = animal['Longitud'];
        let latitud = animal['Latitud'];
	    let foto =  new Image();
        foto.src = 'data:image/jpeg;base64,' + animal['Foto'];
        markerColor = Math.floor(Math.random()*16777215).toString(16);
        let marker = new mapboxgl.Marker
        ({
            anchor: "center",
            color: "#" + markerColor				   
        })
        .setLngLat([longitud, latitud])
        .setPopup(new mapboxgl.Popup().setHTML
        (
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
        .addTo(map);
        markerGroup[animal['ID']] = marker;
    });

    map.addControl(new mapboxgl.NavigationControl());
    hideLoading();
}