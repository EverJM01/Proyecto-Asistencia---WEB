<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");
$idest = $_GET["idest"];
$nombre = $_GET["nombre"];
$telefono = $_GET["tel"];


$sql_apoderados = $conn -> prepare("INSERT into apoderado(id, nom_ape,telefono, id_estudiante) values (null, ?, ?, ?) ");

$sql_apoderados->bind_param("ssi", $nombre, $telefono, $idest);
$sql_apoderados->execute();
$sql_apoderados->close();
echo json_encode("listo");



?>