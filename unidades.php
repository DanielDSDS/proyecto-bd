<?php 
    require_once('conexion/conexion.php');
    include_once 'includes/header.php'; 

    $count = "SELECT COUNT(*) FROM Sedes";
    $query = "SELECT * FROM Unidades;";
    $result = pg_query($db_connection, $query);
    $count_result = pg_query($db_connection, $query);
?>
<html>
    <head>
        <title>Unidades</title>
        <link rel='shortcut icon' href='favicon.ico' type='image/x-icon'/>
    </head>
    <body>
        <div class="mx-auto mt-4 mb-4" style="width: 192px;">
            <span class="titulo">Unidades <i class="align-middle material-icons">location_city</i></span>
        </div>
        <div class="add-sede rounded-lg shadow bg-light pb-2 pt-2 ml-3 mr-3">
            <div class="mx-auto mt-2 mb-4 text-center">
                <span class="subtitulo">Añadir Unidad</span>
            </div>
            <form class="needs-validation ml-5 mr-5" id="add_unidad" action="add-unidad.php" method="post" novalidate>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="validationTooltip01">Sede perteneciente</label>
                        <select id="select-sedes" class="form-control">
                            <option value="NULL" disabled selected>Seleccionar una sede</option>
                            <?
                                $listar_sedes = "SELECT codigo_sede, descripcion FROM Sedes;";
                                $result_search = pg_query($db_connection, $listar_sedes);
                                while($row = pg_fetch_row($result_search)){
                            ?>
                                <option value="<?echo $row[0];?>"><?echo $row[1];?></option>
                            <?}

                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationTooltip04">Empleado Responsable</label>
                        <select id="select-responsable" class="form-control">
                            <option value="-1" disabled selected>Seleccionar un responsable</option>
                            <?
                                $listar_empleados = "SELECT ficha_empleado,nombre FROM Empleados, Nombre_empleados;";
                                $result_emp = pg_query($db_connection, $listar_empleados);
                                while($row = pg_fetch_row($result_emp)){
                            ?>
                                <option value="<?echo $row[0];?>"><?echo $row[1];?></option>
                            <?}

                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationTooltip02">Nombre de la Unidad</label>
                        <input type="text" name="nombre_unidad" class="form-control" id="nombre_unidad" placeholder="Nombre" required>
                    </div>
                </div>
                <div class="mx-auto text-center">
                    <button class="btn btn-success" id="add_unidad_btn" type="button">Añadir</button>
                </div>
            </form>
            <div class="subtitulo mx-auto rounded bg-success round text-light text-center d-none"  id="add-unidad-success">
                <span class="mx-auto">Unidad añadida correctamente</span>
            </div>
            <div class="subtitulo mx-auto rounded bg-danger round text-light text-center d-none"  id="add-unidad-error">
                <span class="mx-auto">La sede no pudo ser añadida, revise los datos </span>
            </div>
        </div>

        <?if(pg_fetch_row($count_result) > 0){?>
        <div id="tabla">
            <div class="all-unidades text-center mx-auto rounded-lg pb-2 mt-5 pt-2 ml-3 mr-3 mb-4">
                <span class="subtitulo mx-auto">Lista de Unidades</span>
            </div>
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr class="mx-auto text-center">
                        <th style="width: 250px;">Codigo</th>
                        <th style="width: 250px;">Sede Perteneciente</th>
                        <th style="width: 250px;">Responsable</th>
                        <th style="width: 250px;">Nombre</th>
                        <th style="width: 150px;"><i class="material-icons">edit</i></th>
                        <th style="width: 150px;"><i class="material-icons"><a type="button" class="text-danger" id="delete-btn">delete</a></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?
                        $i = 0;
                        while($row = pg_fetch_row($result)){
                            $i++;
                            ?>
                                <tr class="text-center" id="input-group<?echo $i;?>">
                                    <td>
                                        <p><?echo $row[0];?></p>
                                        <input id="f1-<?echo $i;?>" type="text" placeholder="<?echo $row[0];?>" value="<?echo $row[0];?>" class="form-control d-none" disabled>
                                    </td>
                                    <td>
                                        <p><?echo $row[1];?></p>
                                        <input id="f2-<?echo $i;?>" type="text" placeholder="<?echo $row[1];?>" value="<?echo $row[1];?>" class="form-control d-none" disabled>
                                    </td>
                                    <td>
                                        <p><?echo $row[2];?></p>
                                        <input id="f3-<?echo $i;?>" type="text" placeholder="<?echo $row[2];?>" value="<?echo $row[2];?>" class="form-control d-none">
                                    </td>
                                    <td>
                                        <p><?echo $row[3];?></p>
                                        <input id="f4-<?echo $i;?>" type="text" placeholder="<?echo $row[3];?>" value="<?echo $row[3];?>" class="form-control d-none">
                                    </td>
                                    <td>
                                        <div id="editar<?echo $i;?>"  class="btn-group-toggle" data-toggle="buttons">
                                            <label class="shadow-sm btn btn-secondary">
                                                <input type="checkbox" autocomplete="off" 
                                                onchange="toggleSave(<?echo $i;?>)"> 
                                                    Editar
                                            </label>
                                        </div>
                                        <button id="guardar<?echo $i;?>" 
                                            onclick="updateData(<?echo $i;?>,'#f1-'+'<?echo $i;?>','#f3-'+'<?echo $i;?>','#f4-'+'<?echo $i;?>')" 
                                            class="d-none btn btn-success" value="<?echo $i?>" type="button">Guardar
                                            <div class="d-none spinner loadingio-spinner-rolling-bqrptym85uo"><div class="ldio-q0sn9pt0muq">
                                            <div></div>
                                            </div></div>
                                        </button>
                                    </td>
                                    <td class="btn-group-toggle eliminar align-middle">        
                                        <label id="eliminar<?echo $i;?>">
                                            Eliminar <input type="checkbox" autocomplete="off" value="<?echo $i;?>">
                                            <div class="d-none spinner-delete loadingio-spinner-rolling-bqrptym85uo"><div class="ldio-q0sn9pt0muq">
                                            <div></div>
                                            </div></div>
                                        </label>
                                    </td>
                                </tr>
                            <?
                        }
                    ?>
                </tbody>
            </table>

            <?}?>
        </div>
    </body>
    <script>

        var indexGlob = 0;

        function toggleSave(index){
            $('#guardar'+ index ).removeClass('d-none')
            $('#input-group'+index+' .form-control').removeClass('d-none')
            $('#input-group'+index+' p').addClass('d-none')
            $('#editar'+index).addClass('d-none')
        }

        function toggleEdit(index,responsable_update,nombre_update){
            $('#guardar'+ index ).addClass('d-none')
            $('#input-group'+index+' .form-control').addClass('d-none')
            $('#input-group'+index+' p').removeClass('d-none')
            $('#editar'+index).removeClass('d-none')
            $('#guardar'+ index + ' .spinner').addClass('d-none')

            $('#input-group'+index+' p')[2].innerText = responsable_update
            $('#input-group'+index+' p')[3].innerText = nombre_update
        }

        function updateData(index,codigo_update,responsable_update,nombre_update){
                $('#guardar'+ index + ' .spinner').removeClass('d-none')
                var codigo_update = $(codigo_update).val()
                var responsable_update = $(responsable_update).val()
                var nombre_update = $(nombre_update).val()
                
                setTimeout(function(){
                    $.ajax({
                        url: "update-sede.php",
                        type: "POST",
                        async: true,
                        data: {
                            codigo_unidad: codigo_update,
                            ficha_responsable: responsable_update,
                            nombre: nombre_update
                        },
                        success: function(){
                            toggleEdit(index,responsable_update,nombre_update)
                        }
                    })
                },300)
        }

        $(document).ready(function(){

            $('#delete-btn').click(function(){
                
                var getcheckboxes = $('input:checked').map(function(){
                    var index = $(this).val()
                    indexGlob = index
                    $('#input-group'+indexGlob).addClass('d-none')
                    $('#eliminar'+ indexGlob + ' .spinner-delete').addClass('d-none')
                    return codigo_unidad = $('#f1-'+index).val()                  
                });
                
                $('#eliminar'+ indexGlob + ' .spinner-delete').removeClass('d-none')
                var codigos = getcheckboxes.get()

                setTimeout(function(){
                    $.ajax({
                        method:'POST',
                        url:'delete-unidad.php',
                        data:{
                            codigos : codigos
                        },
                        async: true,
                        success: function(){
                            <?
                            $conteo = pg_query($db_connection, $count);
                            if(pg_fetch_row($count_result) == 0){    
                            ?>
                                $('#tabla').hide()
                            <?}?>
                        },
                        error: function(){
                            alert('error')
                        }
                    })
                },500)
            })

            $('#add_unidad_btn').click(añadirUnidad)

            function añadirUnidad(){
                var codigo_sede = $('#select-sedes').val()
                var nombre_unidad = $('#nombre_unidad').val()
                var ficha_responsable = $('#select-responsable').val()
                if(ficha_responsable == null){
                    ficha_responsable = 'DEFAULT';
                }
                $.ajax({
                    method:'POST',
                    url:'add-unidad.php',
                    data: {
                        codigo_sede: codigo_sede, 
                        nombre_unidad: nombre_unidad,
                        ficha_responsable: ficha_responsable
                        },
                    success: function(){
                        $('#add-unidad-success').removeClass('d-none')
                    },
                    error: function(){
                        $('#add-unidad-error').removeClass('d-none')
                    }
                })
            }   
        })
    </script>
</html> 
