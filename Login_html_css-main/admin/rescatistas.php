
<!DOCTYPE html>
<html lang="es">

<!DOCTYPE html>
<html lang="es">

<head>

<!-- mapboxs-->
<script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
<!--mapboxs-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Añadir rescatista</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/burgerMenu.css">
    <script src="mainAdminCrud.js"></script>
</head>

<body>
    <nav>
      <div class="navbar">
        <div class="container nav-container">
            <input class="checkbox" type="checkbox" name="" id="" />
            <div class="hamburger-lines">
              <span class="line line1"></span>
              <span class="line line2"></span>
              <span class="line line3"></span>
            </div>  
          <div class="logo">
            <h1>Navbar</h1>
          </div>
          <div class="menu-items">
            <li><a href="#">Home</a></li>
            <li><a href="#">about</a></li>
            <li><a href="#">blogs</a></li>
            <li><a href="#">portfolio</a></li>
            <li><a href="#">contact</a></li>
          </div>
        </div>
      </div>
    </nav>

    <h1 style="text-align: center">Create</h1>
    <div class="ui form">
      <form id="create_user" style="margin-bottom: 30px">
        <div class="required field">
          <label>Name</label>
          <input id="name" type="text" name="name" placeholder="Name" />
        </div>
        <div class="required field">
          <label>Birthday</label>
          <input id="birthday" type="text" name="birthday" placeholder="dd/mm/yyyy"></input>
        </div>
        <div class="required field">
          <label>Phone</label>
          <input id="phone" type="number" name="phone" placeholder="0901234567"></input>
        </div>
        <div class="field">
          <label>E-mail</label>
          <input id="email" type="email"  name="email" placeholder="joe@schmoe.com">
        </div>
        <div class="field">
          <label>Country</label>
          <input id="country" type="text" name="country" placeholder="Vietnam"></input>
        </div>

        <!-- <input id="name" type="text" placeholder="Name"></input>
        <input id="birthday" type="text" placeholder="Birthday: dd/mm/yyyy"></input>
        <input id="country" placeholder="Country"></input>
        <input id="email" type="text" placeholder="Email: abc@gmail.com"></input>
        <input id="phone" type="text" placeholder="Phone: 0901234567"></input> -->
      </form>  
      <div style="display: flex; justify-content: center">
        <a id="back" class="ui basic button" href="index.html">Back</a>
        <button id="create" class="ui submit button" onClick="apiCreate()">
          Create
        </button>
      </div>
    </div>
    <!-- <script>apiCreate()</script> -->
  </body>

  </body>
</html>
