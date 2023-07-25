var oldIdModify = ""; //Esta variable se usa para indicar la vieja ID del renglon de la tabla modificada.
var modifyPassword = false; //Es la variable booleana que indica si se modificara la contraseña o no.
var selectedRow = 0; //En esta variable se indica cual renglon de la tabla es el seleccionado.

//Esta función se encarga de obtener a todos los usuarios.
function retirarUsuarios()
{
    //Se accesa la API encargada de los datos del usuario por medio de una función asincrona (AJAX)...
    fetch('../api/apiUserData.php')
        .then((response) => 
        {
            //Si hay un error en la respuesta (El JSON solicitado), tira error.
            if(!response.ok){ 
                throw new Error("No!");
            }

            //Si no hay errores, se captura el JSON.
            return response.json(); 
        })
        .then((data) => 
        {
            //Para manejar los datos por medio de ciclos foreach, ocupamos convertir el JSON array a un
            //arreglo regular, dado a que los ciclos foreach no aplican a JSON Arrays.

            let arrayData = []; //Variable que almacena el Array de los usuarios.
            let arrayKeys = [], arrayInnerKeys = []; //Variables encargadas de guardar las llaves de los arreglos.

            arrayKeys = Object.keys(data); //Obtiene la primera dimensión de llaves del arreglo.

            //Por cada elemento dentro del JSON, se copian los valores del JSON Array original, al array actual.
            arrayKeys.forEach(key => 
            {
                arrayData[key] = (data[key] == null ? "" : data[key]);
            });

            //Se repite el mismo proceso que arriba, pero con la segunda dimensión de llaves.
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
           
            //Aqui se definen los campos del grid de la tabla. Cada campo va a contener un dato del usuario.
            //Tambien vamos a definir variables para un boton de modificación y uno de eliminación en cada
            //renglon.
            let gridItem1, gridItem2, gridItem3, gridItem4, gridItem5, btnModify, btnDelete,
            idRow = 0;
    
            //Por cada usuario que hay en el arreglo...
            arrayData['Usuario'].forEach(element => 
            {
                //El primer elemento del renglon se creara un contenedor, un id unica, el telefono del usuario
                //y finalmente, se anexa al gridItem.
                gridItem1 = document.createElement("div");
                gridItem1.className = "grid-item userphone";
                gridItem1.id = "telefono-usuario-" + idRow;
                gridItem1.innerHTML += element['Telefono'];
                document.getElementById('gridUsers').appendChild(gridItem1);

                //El segundo elemento del renglon se creara un contenedor, un id unica, el nombre del usuario
                //y finalmente, se anexa al gridItem.
                gridItem2 = document.createElement("div");
                gridItem2.className = "grid-item username";
                gridItem2.innerHTML += element['Nombre'];
                document.getElementById('gridUsers').appendChild(gridItem2);


                //El tercer elemento del renglon se creara un contenedor, un id unica, el apellido del usuario
                //y finalmente, se anexa al gridItem.
                gridItem3 = document.createElement("div");
                gridItem3.className = "grid-item userlname";
                gridItem3.innerHTML += element['Apellido'];
                document.getElementById('gridUsers').appendChild(gridItem3);

                //El cuarto elemento del renglon se creara un contenedor, un id unica, el tipo del usuario
                //y finalmente, se anexa al gridItem.
                gridItem4 = document.createElement("div");
                gridItem4.className = "grid-item usertype";
                gridItem4.innerHTML += element['Tipo_Usuario'];
                document.getElementById('gridUsers').appendChild(gridItem4);
                
                //El quinto elemento del renglon se creara un contenedor, un id unica, centra los futuros elementos
                //y finalmente, se anexa al gridItem.
                gridItem5 = document.createElement("div");
                gridItem5.className = "grid-item";
                gridItem5.id = "fila-" + idRow;
                gridItem5.setAttribute("style", "justify-content: center;");
                document.getElementById('gridUsers').appendChild(gridItem5);

                //Se crea un elemento de boton de modificaciones para el gridItem5, su id unica, se le
                //anexa el modal de modificar en el html, y finalmente se anexa al HTML.
                btnModify = document.createElement("label");
                btnModify.className = "btn btn-editar";
                btnModify.innerHTML += "*";
                btnModify.id = 'btn-' + idRow;
                btnModify.htmlFor = 'modal-modify';
                document.getElementById('fila-' + idRow).appendChild(btnModify);

                //Aqui se agrega el click listener para llamar el formulario de modificación y popularlo con
                //los datos del renglon seleccionado.
                //Esta parte es algo complicada de entender; se tiene que hacer una delegación de funciones
                //para separar el scope local de la variable del id, de otra forma todos los renglones tendrian
                //el mismo click listener por que se tomaria el id mas reciente.
                //Si se hace mas local la variable delegandola otra función, se crean click listener individuales
                //para cada renglon, en vez del mas reciente.

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

                
                //Se hace el mismo proceso que el boton de modificar, pero para eliminar.

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


                //Aumenta el contador para indicar que es un renglon diferente; esto es para cambiar las ID.
                idRow += 1;
            });
        })
}

//Esta función se encarga de obtener la información del usuario dinamicamente durante el runtime.
//Esta función es exclusivamente utilizada en modificaciones y eliminaciones.
async function getUserInfoDynamic()
{
    //Se obtiene el numero de renglon por medio del click listener, y de esta forma se obtiene el ID
    //unico del renglon.
    let elemento = 'telefono-usuario-'.concat(selectedRow);
    console.log(elemento);

    //Se crea un JSON del telefono usuario.
    var usuario = {
        telefono: document.getElementById(elemento).textContent,
        };

    //Se inicia un AJAX con la API del usuario, para obtener sus datos por medio de una función asincrona.
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

//Esta función se encarga de manejar todas las funciones de los modals al recibir un click.
async function setModalListener()
{
    //Aqui se distingue si es un modal de modificación o eliminación.
    var checkbox = document.querySelector("input[name=modal-modify]");
    var checkboxdel = document.querySelector("input[name=modal-delete]");

    //Por defecto, se indica que no se cambiara la contraseña.
    modifyPassword = false;

    //Aqui se coloca que pasa cuando se accede al modal de modificaciones, por medio de una función asincrona.
    checkbox.addEventListener('change', async function() {
        if (this.checked) 
        {
            //Se espera la respuesta de la solicitud de información del usuario.
            var data = await getUserInfoDynamic();

            //Se asigna en los campos del modal de modificación los datos del usuario seleccionado.
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

    //Aqui se coloca que pasa cuando se accede al modal de eliminaciones, por medio de una función asincrona.
    checkboxdel.addEventListener('change', async function() {
    if (this.checked) 
    {
        //Se obtienen los datos del usuario.
        var data = await getUserInfoDynamic();

        //Se guarda el telefono en el formulario oculto de eliminaciones.
        document.getElementById("delete-telefono").value = data[0]['Telefono'];       
        console.log(document.getElementById("delete-telefono").value);
    } 
    });
}


//Esta función maneja el CSS de los campos de modificacion de contraseña en el modal de modificaciones.
//Esto se hace añadiendo y removiendo clases que muestran y esconden los campos.
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

//A la hora de modificar la contraseña, te pide la contraseña original. Esta función se encarga de revisar eso.
async function verificarContrasena()
{
    //Si se modificara la contraseña, se procede a la confirmación.
    if(modifyPassword)
    {
        //Por medio de la API, se hace un inicio de sesión mock para comprobar que la contraseña sea correcta.
        let confirmacion = await apiVerificarContrasena();

        //Solo si es correcta, sube el formulario.
        if(confirmacion == true)
        {
            document.getElementById("modificar_user").submit();
        }
    }
    else
    {
        //Si no se modificara la contraseña, solo se sube el formulario.
        document.getElementById("modificar_user").submit();
    }
}


//Codigo de acceso de la API encargada de verificar la contraseña para modificaciones.
async function apiVerificarContrasena()
{
    var usuario = {
        telefono: document.getElementById('telefono-usuario').value,
        contrasena: document.getElementById('password-usuario-old').value,
        };

    let confirmacion=false;

    //Aqui se inicia el AJAX.
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
            //Si el inicio se sesión pasa, se habilita la confirmación.
            if(data['contrasena'] == "Correcta")
            {
                confirmacion = true;
            }
            else
            {
                if(document.getElementById('password-usuario-old').value != "")
                {
                    //Si no, se deniega y avisa al usuario que la contraseña original no es la correcta.
                    confirmacion = false;
                    alert("Contraseña incorrecta");
                }
            }

            //Se entrega la confirmación
            return confirmacion;
        });
}

//A la hora de crear el usuario, se verifica si el telefono ya existe o no. Utiliza el mismo mecanismo que el
//de verificación de contraseña.
async function verificarTelefono()
{ 
    let confirmacion = await apiVerificarTelefono();
    
    if(confirmacion == true)
    {
        document.getElementById("crear_user").submit();
    }
}

//API para la verificación del telefono.
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

//Esta función se encarga de modificar el usuario en la base de datos por medio de AJAX.
async function modifyUser()
{
    //Dependiendo de si se modifico o no se modifico la contraseña, se crea el JSON de diferente forma.
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

    //Inicio del AJAX.
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

//Esta función unicamente se usa para actualizar la pagina a la hora de modificar el usuario, para que se reflejen
//inmediatamente los cambios.
async function apiModificar()
{
    var data = await modifyUser();
    location.reload(true);
}