<?php 
    require_once('conexion/conexion.php');
    include_once 'includes/header.php'; 

    $count = "SELECT COUNT(*) FROM Sedes";
    $query = "SELECT * FROM Sedes ORDER BY codigo_sede ASC;";
    $result = pg_query($db_connection, $query);
    $count_result = pg_query($db_connection, $query);

?>

<html>
    <head>
        <style type="text/css">
            @keyframes ldio-q0sn9pt0muq {
            0% { transform: translate(-50%,-50%) rotate(0deg); }
            100% { transform: translate(-50%,-50%) rotate(360deg); }
            }
            .ldio-q0sn9pt0muq div {
            position: absolute;
            width: 30.99px;
            height: 30.99px;
            border: 5.91px solid #3be8b0;
            border-top-color: transparent;
            border-radius: 50%;
            }
            .ldio-q0sn9pt0muq div {
            animation: ldio-q0sn9pt0muq 1s linear infinite;
            top: 48.5px;
            left: 48.5px
            }
            .loadingio-spinner-rolling-bqrptym85uo {
            width: 100px;
            height: 100px;
            display: inline-block;
            overflow: hidden;
            background: rgba(241, 242, 243, 0);
            }
            .ldio-q0sn9pt0muq {
            width: 20%;
            height: 20%;
            position: relative;
            transform: translateZ(0) scale(1);
            backface-visibility: hidden;
            transform-origin: 0 0; /* see note above */
            }
            .ldio-q0sn9pt0muq div { box-sizing: content-box; }
            /* generated by https://loading.io/ */
        </style>
        <title>Sedes</title>
        <link rel='shortcut icon' href='favicon.ico' type='image/x-icon' />
    </head>
    <body>
        <div class="mx-auto mt-4 mb-4" style="width: 133px;">
            <span class="titulo">Sedes <i class="align-middle material-icons"> business</i></span>
        </div>
        <div class="add-sede rounded-lg shadow bg-light pb-2 pt-2 ml-3 mr-3">
            <div class="mx-auto mt-2 mb-4 text-center">
                <span class="subtitulo">Añadir Sede</span>
            </div>

            <form class="needs-validation ml-5 mr-5" id="add_sede" action="add-sede.php" method="post" novalidate>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="validationTooltip01">Descripcion</label>
                        <input type="text" name="descripcion" class="form-control" id="descripcion" placeholder="Descripcion"required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationTooltip02">Ciudad</label>
                        <input type="text" name="ciudad" class="form-control" id="ciudad" placeholder="Ciudad" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationTooltip02">Estado</label>
                        <input type="text" name="estado" class="form-control" id="estado" placeholder="Estado" required>
                    </div>
                </div>
                <div class="mx-auto text-center">
                    <button class="btn btn-success" id="add_sede_btn" type="button">Añadir</button>
                </div>
            </form>
            <div class="subtitulo mx-auto rounded bg-success round text-light text-center d-none"  id="add-sede-success">
                <span class="mx-auto">Sede creada correctamente</span>
            </div>
            <div class="subtitulo mx-auto rounded bg-danger round text-light text-center d-none"  id="add-sede-error">
                <span class="mx-auto"> La sede no pudo ser creada, revise los datos </span>
            </div>
        </div>
        <?if (pg_fetch_row($count_result) > 0){?>
        <div id="tabla">
            <div class="all-sedes text-center mx-auto rounded-lg pb-2 mt-5 pt-2 ml-3 mr-3 mb-3">
                <h4 class="subtitulo mx-auto">Lista de Sedes</h4>
            </div>
            <table class="table table-hover ">
                <thead class="thead-dark">
                    <tr class="mx-auto text-center">
                        <th style="width: 350px;">Codigo</th>
                        <th style="width: 350px;">Descripcion</th>
                        <th style="width: 350px;">Direccion</th>
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
                                        <input id="f2-<?echo $i;?>" type="text" placeholder="<?echo $row[1];?>" value="<?echo $row[1];?>" class="form-control d-none">
                                    </td>
                                    <td>
                                        <p><?echo $row[2];?></p>
                                        <input id="f3-<?echo $i;?>" type="text" placeholder="<?echo $row[2];?>" value="<?echo $row[2];?>" class="form-control d-none">
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
                                            onclick="updateData(<?echo $i;?>,'#f1-'+'<?echo $i;?>','#f2-'+'<?echo $i;?>','#f3-'+'<?echo $i;?>')" 
                                            class="d-none btn btn-success" value="<?echo $i?>" type="button">Guardar
                                            <div class="d-none spinner loadingio-spinner-rolling-bqrptym85uo"><div class="ldio-q0sn9pt0muq">
                                            <div></div>
                                            </div></div>
                                        </button>
                                    </td>
                                    <td class="btn-group-toggle eliminar align-middle">        
                                        <label id="eliminar<?echo $i;?>">
                                            Eliminar <input type="checkbox" autocomplete="off" value="<?echo $i;?>">
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
        var indexGlob = 0

        function toggleSave(index){
            $('#guardar'+ index ).removeClass('d-none')
            $('#input-group'+index+' .form-control').removeClass('d-none')
            $('#input-group'+index+' p').addClass('d-none')
            $('#editar'+index).addClass('d-none')
        }

        function toggleEdit(index,descripcion_update,direccion_update){
            $('#guardar'+ index ).addClass('d-none')
            $('#input-group'+index+' .form-control').addClass('d-none')
            $('#input-group'+index+' p').removeClass('d-none')
            $('#editar'+index).removeClass('d-none')
            $('#guardar'+ index + ' .spinner').addClass('d-none')

            $('#input-group'+index+' p')[1].innerText = descripcion_update
            $('#input-group'+index+' p')[2].innerText = direccion_update
        }

        function updateData(index,codigo_update,descripcion_update,direccion_update){
                $('#guardar'+ index + ' .spinner').removeClass('d-none')
                var codigo_update = $(codigo_update).val()
                var descripcion_update = $(descripcion_update).val()
                var direccion_update = $(direccion_update).val()
                
                setTimeout(function(){
                    $.ajax({
                        url: "update-sede.php",
                        type: "POST",
                        async: true,
                        data: {
                            codigo_sede: codigo_update,
                            descripcion: descripcion_update,
                            direccion: direccion_update
                        },
                        success: function(){
                            toggleEdit(index,descripcion_update,direccion_update)
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
                    return codigo_sede = $('#f1-'+index).val()                  
                });
                
                var codigos = getcheckboxes.get()

                setTimeout(function(){
                    $.ajax({
                        method:'POST',
                        url:'delete-sede.php',
                        data:{
                            codigos : codigos
                        },
                        async: true,
                        success: function(){
                            <?
                                if(pg_fetch_row($count_result) == 0){    
                            ?>
                                $('#tabla').hide()
                            <?}?>
                        },
                        error: function(){
                            alert('error')
                        }
                    })
                })
            })

            $('#add_sede_btn').click(crearSede)

            function crearSede(){
                var descripcion = $('#descripcion').val()
                var ciudad = $('#ciudad').val()
                var estado = $('#estado').val()
                var direccion = ciudad + ', ' + estado

                setTimeout(function(){
                    $.ajax({
                        method:'POST',
                        url:'add-sede.php',
                        data: {
                            descripcion: descripcion, 
                            direccion: direccion
                            },
                        success: function(){
                            $('#add-sede-success').removeClass('d-none')
                        },
                        error: function(){
                            $('#add-sede-error').removeClass('d-none')
                        }
                    })
                },300)
            }   

        })
        
    </script>
</html> 

