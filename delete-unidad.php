<?
    require_once('conexion/conexion.php');

    $codigos = $_POST['codigos'];
    foreach($codigos as $codigo_unidad){
        $query = "DELETE FROM Unidades WHERE codigo_unidad = '$codigo_unidad';";
        $result = pg_query($db_connection,$query);
        echo $result;
    }
?>