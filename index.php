<?php 
    require_once('conexion/conexion.php');
    include_once 'includes/header.php'; 

    $sedes = 'SELECT descripcion,direccion FROM Sedes;';

    $conteo_sedes = 'SELECT COUNT(*) FROM Sedes;';

    $unidades = 'SELECT codigo_unidad,codigo_sede,ficha_responsable,nombre FROM Unidades
    ORDER BY codigo_sede;';

    $conteo_unidades = 'SELECT COUNT(*) FROM Unidades;';

    $empleados = 'SELECT Nombre_empleados.nombre, Unidades.nombre
    FROM Empleados,Nombre_empleados,Unidades
    WHERE Empleados.cedula = Nombre_empleados.cedula AND  Unidades.codigo_unidad = Empleados.codigo_unidad;';

    $conteo_empleados = 'SELECT COUNT(*) FROM Empleados;';

    $result = pg_query($db_connection,$sedes);
    
    $result2 = pg_query($db_connection,$conteo_sedes);

    $result3 = pg_query($db_connection,$unidades);
    
    $result4 = pg_query($db_connection,$conteo_unidades);

    $result5 = pg_query($db_connection,$empleados);

    $result6 = pg_query($db_connection,$conteo_empleados);
?>
<html>
    <head>
        <title>Sistema de Inventariado UCAB</title>
        <link rel='shortcut icon' href='favicon.ico' type='image/x-icon' />
    </head>
    <body>
        <div class="mx-auto mt-4 mb-4" style="width: 190px;">
            <span class="titulo">Estadisticas</span>
        </div>
        <div class="row mx-auto">
            <div class="sedes acordion col" id="accordionExample0">
                <div class="card shadow mx-auto" style="width: 18rem;">
                    <h5 class="subtitulo card-header">Sedes<i class="align-bottom material-icons">business</i></h5>
                    <img src="res/ucabg.jpg" height="161.2px" class="card-img-top">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseZero" aria-expanded="true" aria-controls="collapseOne">
                    <b class="texto card-body bold"><?echo  pg_fetch_row($result2)[0];?> Sedes registradas 
                            <i class="material-icons align-bottom">arrow_drop_down</i>
                        </b>
                        </button>
                                <div id="collapseZero" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample0">
                                    <ul class="list-group list-group-flush">
                                        <?
                                            while($row = pg_fetch_row($result)){
                                                ?> <li class=" texto list-group-item"><? echo trim($row[0]) .' - '. trim($row[1]); ?></li><?
                                            }
                                        ?>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <a href="sedes.php" class="card-link">Añadir Sede <i class="align-bottom material-icons">add</i></a>
                                </div>
                            </div>
            </div>
            <div class="unidades acordion col" id="accordionExample">
                <div class="card shadow mx-auto" style="width: 18rem;">
                    <h5 class="subtitulo card-header">Unidades<i class="align-bottom material-icons"> location_city</i></h5>
                    <img src="res/unidades.jpg" height="161.2px" class="card-img-top">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <b class="texto card-body bold"><?echo  trim(pg_fetch_row($result4)[0]);?> Unidades registradas 
                            <i class="material-icons align-bottom">arrow_drop_down</i>
                        </b>
                    </button>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <ul class="list-group list-group-flush">
                            <?
                                while($row = pg_fetch_row($result3)){
                                    $buscar_sede = "SELECT descripcion FROM Sedes WHERE codigo_sede = '$row[1]' ;";
                                    $result_search = pg_query($db_connection, $buscar_sede);
                                ?> <li class=" texto list-group-item"><? echo trim($row[3]) .'  ('.trim(pg_fetch_row($result_search)[0]).') '; ?></li><?
                                }
                            ?>
                        </ul>
                    </div>
                    <div class="card-body">
                        <a href="unidades.php" class="card-link">Añadir Unidad <i class="align-bottom material-icons">add</i></a>
                    </div>
                </div>
            </div>
            <div class="empleados acordion col" id="accordionExample2">
                <?
                    if($result5){
                        ?>
                            <div class="card mx-auto shadow" style="width: 18rem;">
                                <h5 class="subtitulo card-header">Empleados<i class="align-bottom material-icons">person</i></h5>
                                <img src="res/empleados.jpg" class="card-img-top">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    <b class="texto card-body bold"><?echo  trim(pg_fetch_row($result6)[0]);?> Empleados Registrados
                                        <i class="material-icons align-bottom">arrow_drop_down</i>
                                    </b>
                                </button>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample2">
                                    <ul class="list-group list-group-flush">
                                        <?
                                            while($row = pg_fetch_row($result5)){     
                                                ?> <li class=" texto list-group-item"><? echo $row[0].' ('.$row[1]; ?>)</li><?
                                            }
                                        ?>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <a href="empleados.php" class="card-link">Añadir Empleados <i class="align-bottom material-icons">person_add</i></a>
                                </div>
                            </div>
                        <?
                    }else{
                        ?>
                        <div>No existe ningun empleado</div>
                        <?
                    }
                ?>
            </div>
        </div>
    </body>
</html>