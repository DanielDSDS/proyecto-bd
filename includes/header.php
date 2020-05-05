<?php
    session_start();
?>
<html>       
    <head>
        <link href="css/global.css" rel="stylesheet" type="text/css" />
        <script src='http://code.jquery.com/jquery-3.1.1.min.js'></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
        </script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </head>

    <nav class="navbar navbar-dark bg-dark" style="background-color: #e3f2fd;">
        <a class="navbar-brand" href="index.php">
            <img src="res/brand-logo.png" width="60" height="59" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="subtitulo nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sedes
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="texto dropdown-item" href="sedes.php">Sedes</a>
                        <a class="texto dropdown-item" href="#">Encargados</a>
                        <a class="texto dropdown-item" href="#">Inventarios</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="subtitulo nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Unidades
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="texto dropdown-item" href="unidades.php">Unidades</a>
                        <a class="texto dropdown-item" href="#">Responsables</a>
                        <a class="texto dropdown-item" href="#">Bienes</a>
                        <a class="texto dropdown-item" href="#">Movilizaciones</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="subtitulo nav-link" href="empleados.php" role="button">
                    Empleados
                    </a>    
                </li>
            </ul>
        </div>
    </nav>
</html>