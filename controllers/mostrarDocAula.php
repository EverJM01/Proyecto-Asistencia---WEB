<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");
$idaula = $_GET["idaula"];

$sql = $conn -> query("SELECT id, nombre, apellido, dni FROM docente where id_aula = $idaula ");
$resultado = array();

$resultado[0] = 'no';
while($row = $sql->fetch_assoc()){
    $resultado[0] = 'si';
    $resultado[] = $row;
}



echo json_encode($resultado);    
?>