const selectEspecie = document.getElementById('selectEspecie');
const selectRaza = document.getElementById('selectRaza');
var razasData = {};


fetch('homeCallSelectOptions.php')
        .then((response) => {

            if(!response.ok){ 
                throw new Error("No!");
            }

            return response.json(); 
        })
        .then((data) => {
            console.log(data);
            let arrayData = Object.keys(data).map(key => data[key]);
            let arrayEspeciesLength = Object.keys(arrayData[0]['Especies']).length;

            console.log(arrayData);

            for(let x = 0; x < arrayEspeciesLength ;x++){
                let option = document.createElement("option");
                option.value = x+1;
                option.text = arrayData[0]['Especies'][x];
                selectEspecie.appendChild(option);
            }

            razasData = arrayData[0]['Razas'];

            console.log(razasData);          
        }) 
