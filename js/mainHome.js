//Aqui se declaran todas las constantes para referirse a los selects de la pagina principal.
const selectEspecie = document.getElementById('selectEspecie');
const selectRaza = document.getElementById('selectRaza');

//Esta constante hace referencia al boton que muestra y esconde los filtros.
const switchFiltros = document.getElementById('switchFiltros');

//Esta otra hace referencia a su contenedor.
const contenedorFiltros = document.getElementById('contenedorFiltros');
var checkGet = "";
var serverResponse;

//Con una función asincrona, se llama a las opciones del select por medio de la API.
fetch('api/apiCallSelectOptions.php')
    .then((response) => 
    {

        if(!response.ok){ 
            throw new Error("No!");
        }

        return response.json(); 
    })
    .then((data) => 
    {
        //Estas variables son los arreglos que van a recibir el JSON Array. 
        //Esta el arreglo general (Data), y los de cada filtro.
        let arrayData = [], arrayEspecies = [], arrayRazas = [];
        
        //Estas variables representan los indices de los arreglos.
        let arrayKeys = [], arrayInnerKeys = [];

        //Se convierte el JSON Array al arrayData.
        arrayKeys = Object.keys(data);
        arrayKeys.forEach(key => 
        {
            arrayData[key] = (data[key] == null ? "" : data[key]);
        });

        //Se obtiene el arreglo de especies.
        arrayKeys = Object.keys(arrayData['Especies']);
        arrayKeys.forEach(key => 
        {
            arrayEspecies[key] = [];

            arrayInnerKeys = Object.keys(arrayData['Especies'][key]);
            arrayInnerKeys.forEach(innerkey => 
            {
                arrayEspecies[key][innerkey] = (arrayData['Especies'][key][innerkey] == null ? "" : arrayData['Especies'][key][innerkey]);
            });              
        });

        //Se anexan los datos obtenidos de especies al select correspondiente.
        let arrayEspeciesLength = arrayEspecies.length;
        for(let x = 0; x < arrayEspeciesLength ;x++){
            let option = document.createElement("option");
            option.value = arrayEspecies[x]['Nombre'].toLowerCase();
            option.text = arrayEspecies[x]['Nombre'];
            selectEspecie.appendChild(option);
        }

        //Se obtiene el arreglo de razas.
        arrayKeys = Object.keys(arrayData['Razas']);
        arrayKeys.forEach(key => 
        {
            arrayRazas[key] = [];

            arrayInnerKeys = Object.keys(arrayData['Razas'][key]);
            arrayInnerKeys.forEach(innerkey => 
            {
                arrayRazas[key][innerkey] = (arrayData['Razas'][key][innerkey] == null ? "" : arrayData['Razas'][key][innerkey]);
            });              
        });

        //Se anexan los datos obtenidos de razas al select correspondiente.
        let arrayRazasLength = arrayRazas.length;
        for(let x = 0; x < arrayRazasLength ;x++){
            let option = document.createElement("option");
            option.value = arrayRazas[x]['Nombre'].toLowerCase();
            option.text = arrayRazas[x]['Nombre'];
            selectRaza.appendChild(option);
        }
    }) 

//Estas funciones es para aplicar el filtro correspondiente por medio de GET.
document.getElementById("selectEspecie").onchange = function()
{
    document.getElementById("formFiltros").submit(); 
}

document.getElementById("selectRaza").onchange = function()
{
    document.getElementById("formFiltros").submit(); 
}


//Esta función es la encargada de mostrar y esconder el formulario de los filtros, por medio del boton.
switchFiltros.onclick = function()
{
    if(!contenedorFiltros.classList.contains("filtrosVisible"))
    {
        contenedorFiltros.classList.remove("filtrosHidden");
        contenedorFiltros.classList.add("filtrosVisible");
    }
    else
    {
        contenedorFiltros.classList.remove("filtrosVisible");
        contenedorFiltros.classList.add("filtrosHidden");
    }
}

