<?
    require_once('conexion/conexion.php');
    include_once 'includes/header.php'; 

    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $codigo_unidad = $_POST['codigo_unidad'];

    $query = "INSERT INTO Nombre_empleados values ('$cedula','$nombre');";
    $query2 = "INSERT INTO Empleados values (DEFAULT,'$cedula','$codigo_unidad');";
    
    $result = pg_query($db_connection,$query);
    $result2 = pg_query($db_connection,$query2);
    

?>