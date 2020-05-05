<?
    require_once('conexion/conexion.php');

    $codigos = $_POST['codigos'];
    foreach($codigos as $codigo_sede){
        $query = "DELETE FROM Sedes WHERE codigo_sede = $codigo_sede;";
        $result = pg_query($db_connection,$query);
        echo $result;
    }
?>