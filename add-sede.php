<?
    require_once('conexion/conexion.php');
    include_once 'includes/header.php'; 


    $descripcion = $_POST["descripcion"];
    $direccion = $_POST["direccion"];
    $query = "INSERT INTO Sedes values (DEFAULT,'$descripcion','$direccion');";
    $result = pg_query($db_connection,$query);
    echo $result;
?>