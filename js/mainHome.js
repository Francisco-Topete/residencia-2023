const selectEspecie = document.getElementById('selectEspecie');
const selectRaza = document.getElementById('selectRaza');
const switchFiltros = document.getElementById('switchFiltros');
const contenedorFiltros = document.getElementById('contenedorFiltros');
var checkGet = "";
var serverResponse;

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
        let arrayData = [], arrayEspecies = [], arrayRazas = [];
        let arrayKeys = [], arrayInnerKeys = [];

        arrayKeys = Object.keys(data);
        arrayKeys.forEach(key => 
        {
            arrayData[key] = (data[key] == null ? "" : data[key]);
        });

        console.log("Mira esto, perro: ");

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

        let arrayEspeciesLength = arrayEspecies.length;
        for(let x = 0; x < arrayEspeciesLength ;x++){
            let option = document.createElement("option");
            option.value = arrayEspecies[x]['Nombre'].toLowerCase();
            option.text = arrayEspecies[x]['Nombre'];
            selectEspecie.appendChild(option);
        }

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

        let arrayRazasLength = arrayRazas.length;
        for(let x = 0; x < arrayRazasLength ;x++){
            let option = document.createElement("option");
            option.value = arrayRazas[x]['Nombre'].toLowerCase();
            option.text = arrayRazas[x]['Nombre'];
            selectRaza.appendChild(option);
        }
    }) 

document.getElementById("selectEspecie").onchange = function()
{
    document.getElementById("formFiltros").submit(); 
}

document.getElementById("selectRaza").onchange = function()
{
    document.getElementById("formFiltros").submit(); 
}

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

