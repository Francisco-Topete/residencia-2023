const selectEspecie = document.getElementById('selectEspecie');
const selectRaza = document.getElementById('selectRaza');


async function loadEspecies() 
{
    fetch('homeCallSelectOptions.php')
            .then((response) => {

                if(!response.ok){ 
                    throw new Error("No!");
                }

                return response.json(); 
            })
            .then((data) => {
                for(let x = 0; x < data.length;x++){
                    let option = document.createElement("option");
                    option.value = x+1;
                    option.text = data[x];
                    selectEspecie.appendChild(option);
                }
            }) 
}



loadEspecies();
