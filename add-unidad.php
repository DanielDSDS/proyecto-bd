<?
    require_once('conexion/conexion.php');
    include_once 'includes/header.php'; 


    $codigo_sede = $_POST["codigo_sede"];
    $nombre_unidad = $_POST["nombre_unidad"];
    $ficha_responsable = $_POST["ficha_responsable"];

    $add_unidad = "INSERT INTO Unidades values (DEFAULT,'$codigo_sede',$ficha_responsable,'$nombre_unidad',DEFAULT);";
    $result = pg_query($db_connection,$add_unidad);
?>