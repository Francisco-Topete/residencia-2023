var oldIdModify = "";
var modifyPassword = false;
var selectedRow = 0;

function retirarUsuarios()
{
    fetch('../api/apiUserData.php')
        .then((response) => 
        {
            if(!response.ok){ 
                throw new Error("No!");
            }

            return response.json(); 
        })
        .then((data) => 
        {
            let arrayData = [];
            let arrayKeys = [], arrayInnerKeys = [];

            arrayKeys = Object.keys(data);
            arrayKeys.forEach(key => 
            {
                arrayData[key] = (data[key] == null ? "" : data[key]);
            });

            arrayKeys = Object.keys(arrayData['Usuario']);
            arrayKeys.forEach(key => 
            {
                arrayData['Usuario'][key] = (data['Usuario'][key] == null ? "" : data['Usuario'][key]);

                arrayInnerKeys = Object.keys(arrayData['Usuario'][key]);
                arrayInnerKeys.forEach(innerkey => 
                {
                    arrayData['Usuario'][key][innerkey] = (data['Usuario'][key][innerkey] == null ? "" : data['Usuario'][key][innerkey]);
                });              
            });
           
            let gridItem1, gridItem2, gridItem3, gridItem4, gridItem5, btnModify, btnDelete,
             idRow = 0;
    
            arrayData['Usuario'].forEach(element => 
            {
                gridItem1 = document.createElement("div");
                gridItem1.className = "grid-item userphone";
                gridItem1.id = "telefono-usuario-" + idRow;
                gridItem1.innerHTML += element['Telefono'];
                document.getElementById('gridUsers').appendChild(gridItem1);

                gridItem2 = document.createElement("div");
                gridItem2.className = "grid-item username";
                gridItem2.innerHTML += element['Nombre'];
                document.getElementById('gridUsers').appendChild(gridItem2);

                gridItem3 = document.createElement("div");
                gridItem3.className = "grid-item userlname";
                gridItem3.innerHTML += element['Apellido'];
                document.getElementById('gridUsers').appendChild(gridItem3);

                gridItem4 = document.createElement("div");
                gridItem4.className = "grid-item usertype";
                gridItem4.innerHTML += element['Tipo_Usuario'];
                document.getElementById('gridUsers').appendChild(gridItem4);
                
                gridItem5 = document.createElement("div");
                gridItem5.className = "grid-item";
                gridItem5.id = "fila-" + idRow;
                gridItem5.setAttribute("style", "justify-content: center;");
                document.getElementById('gridUsers').appendChild(gridItem5);

                btnModify = document.createElement("label");
                btnModify.className = "btn btn-editar";
                btnModify.innerHTML += "*";
                btnModify.id = 'btn-' + idRow;
                btnModify.htmlFor = 'modal-modify';
                document.getElementById('fila-' + idRow).appendChild(btnModify);

                function delegarClick(id)
                {
                    return function(){
                        clickear(id);
                    }
                }

                function clickear(id)
                {
                    selectedRow = id;
                    console.log(selectedRow);
                }

                document.getElementById(btnModify.id).addEventListener("click", delegarClick(idRow), false); 

                btnDelete = document.createElement("label");
                btnDelete.className = "btn btn-eliminar";
                btnDelete.innerHTML += "-";
                btnDelete.id = 'btndel-' + idRow;
                btnDelete.htmlFor = 'modal-delete';
                document.getElementById('fila-' + idRow).appendChild(btnDelete);

                function delegarClickDel(id)
                {
                    return function(){
                        clickearDel(id);
                    }
                }

                function clickearDel(id)
                {
                    selectedRow = id;
                    console.log(selectedRow);
                }

                document.getElementById(btnDelete.id).addEventListener("click", delegarClickDel(idRow), false);

                idRow += 1;
            });
        })
}

async function getUserInfoDynamic()
{
    let elemento = 'telefono-usuario-'.concat(selectedRow);
    console.log(elemento);

    var usuario = {
        telefono: document.getElementById(elemento).textContent,
        };

    const options = {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        },
        body: JSON.stringify(usuario),
        };

    return fetch('../api/apiSingleUserData.php', options)
        .then((response)=>
        {
            if(!response.ok){ 
                throw new Error("No!");
            }
            return response.json();
        })
        .then((data)=>
        {
            return data
        });
}

async function setModalListener()
{
    var checkbox = document.querySelector("input[name=modal-modify]");
    var checkboxdel = document.querySelector("input[name=modal-delete]");

    modifyPassword = false;
    checkbox.addEventListener('change', async function() {
        if (this.checked) 
        {
            var data = await getUserInfoDynamic();
            document.getElementById("telefono-usuario").value = data[0]['Telefono'];
            oldIdModify = data[0]['Telefono'];
            document.getElementById("telefono-old").value = oldIdModify;
            document.getElementById("nombre-usuario").value = data[0]['Nombre'];
            document.getElementById("apellido-usuario").value = data[0]['Apellido'];
            console.log(data[0]['Tipo_Usuario']);
            
            switch(data[0]['Tipo_Usuario']) 
            {
                case 'Administrador':
                    document.getElementById("select-rol-usuario").value = 1;
                break;
                case 'Coordinador':
                    document.getElementById("select-rol-usuario").value = 2;
                break;
                case 'Rescatista':
                    document.getElementById("select-rol-usuario").value = 3;
                break;
            }           
        } 
      });

    checkboxdel.addEventListener('change', async function() {
    if (this.checked) 
    {
        var data = await getUserInfoDynamic();
        document.getElementById("delete-telefono").value = data[0]['Telefono'];       
        console.log(document.getElementById("delete-telefono").value);
    } 
    });
}

function cambiarContrasena()
{
    if(document.getElementById("password-old-div").classList.contains("password-field-show") ||
       document.getElementById("password-new-div").classList.contains("password-field-show"))
    {
        document.getElementById("password-old-div").classList.remove("password-field-show");
        document.getElementById("password-usuario-old").value='';
        document.getElementById("password-usuario-old").required = false;
        document.getElementById("password-new-div").classList.remove("password-field-show");
        document.getElementById("password-usuario-new").value='';
        document.getElementById("password-usuario-new").required = false;
        modifyPassword = false;   
        oldIdModify = "";
    }
    else
    {
        document.getElementById("password-old-div").classList.add("password-field-show");
        document.getElementById("password-usuario-old").required = true;
        document.getElementById("password-new-div").classList.add("password-field-show");
        document.getElementById("password-usuario-new").required = true;
        modifyPassword = true;
        oldIdModify = document.getElementById("telefono-old").value;
    }
}

async function verificarContrasena()
{
    if(modifyPassword)
    {
        let confirmacion = await apiVerificarContrasena();

        if(confirmacion == true)
        {
            document.getElementById("modificar_user").submit();
        }
    }
    else
    {
        document.getElementById("modificar_user").submit();
    }
}

async function apiVerificarContrasena()
{
    var usuario = {
        telefono: document.getElementById('telefono-usuario').value,
        contrasena: document.getElementById('password-usuario-old').value,
        };

    let confirmacion=false;

    const options = {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        },
        body: JSON.stringify(usuario),
        };

    return fetch('../api/apilogin.php', options)
        .then((response)=>
        {
            if(!response.ok){ 
                throw new Error("No!");
            }

            return response.json();
        })
        .then((data)=>
        {
            if(data['contrasena'] == "Correcta")
            {
                confirmacion = true;
            }
            else
            {
                if(document.getElementById('password-usuario-old').value != "")
                {
                    confirmacion = false;
                    alert("Contraseña incorrecta");
                }
            }

            return confirmacion;
        });
}

async function verificarTelefono()
{ 
    let confirmacion = await apiVerificarTelefono();
    
    if(confirmacion == true)
    {
        document.getElementById("crear_user").submit();
    }
}

async function apiVerificarTelefono()
{
    var usuario = {
        telefono: document.getElementById('crear-telefono-usuario').value,
        contrasena: document.getElementById('crear-password-usuario').value,
        };

    let confirmacion=false;

    const options = {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        },
        body: JSON.stringify(usuario),
        };

    return fetch('../api/apilogin.php', options)
        .then((response)=>
        {
            if(!response.ok){ 
                throw new Error("No!");
            }

            return response.json();
        })
        .then((data)=>
        {
            console.log(data);
            if(data['telefono'] != "Correcto")
            {       
                console.log("confirmado");
                confirmacion = true;
            }
            else
            {
                confirmacion = false;
                alert("Ese usuario ya existe.");
            }

            return confirmacion;
        });
}

async function modifyUser()
{
    if(modifyPassword == true)
    {
        var usuario = {
            telefono: document.getElementById('telefono-usuario').value,
            telefono_old: oldIdModify,
            nombre: document.getElementById('nombre-usuario').value,
            apellido: document.getElementById('apellido-usuario').value,
            tipo_usuario: document.getElementById('select-rol-usuario').value,
            contrasena_old: document.getElementById('password-usuario-old').value,
            contrasena_new: document.getElementById('password-usuario-new').value,
            };
    }
    else
    {
        var usuario = {
            telefono: document.getElementById('telefono-usuario').value,
            telefono_old: oldIdModify,
            nombre: document.getElementById('nombre-usuario').value,
            apellido: document.getElementById('apellido-usuario').value,
            tipo_usuario: document.getElementById('select-rol-usuario').value,
            };
    }

    const options = {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        },
        body: JSON.stringify(usuario),
        };

    return fetch('../api/apiModifyUser.php', options)
        .then((response)=>
        {
            if(!response.ok){ 
                throw new Error("No!");
            }
            return response.json();
        })
        .then((data)=>
        {
            return data
        });
}

async function apiModificar()
{
    var data = await modifyUser();
    location.reload(true);
}


