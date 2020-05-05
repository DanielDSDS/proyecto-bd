<?
    require_once('conexion/conexion.php');

    $codigo_sede = $_POST['codigo_sede'];
    $descripcion = $_POST['descripcion'];
    $direccion = $_POST['direccion'];

    $query = "UPDATE Sedes SET descripcion = '$descripcion', direccion = '$direccion' WHERE codigo_sede = '$codigo_sede'; ";
    $result = pg_query($db_connection,$query);
    echo $result;  
?>