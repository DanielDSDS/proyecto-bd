<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <?php
        session_start();
        $host = "localhost";
        $port = "5432";
        $dbname = "ProyectoBD1";
        $user = "postgres"; 
        $pass = "Danielacho123";
        $db_connection = pg_connect("host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$pass);
            
        if(!$db_connection) {
            ?> 
            <div class="text-center bg-danger p-1">
                <div class="text-light mx-auto">La conexion no pudo ser establecido </div> 
            </div><?
        } else {
            ?> 
            <div class="text-center bg-primary p-1">    
                <div class="text-light mx-auto">Conexion establecida </div> 
            </div>
            <?
        }
    ?>
</html>