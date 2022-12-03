<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");
$nom = $_GET["nom"];
$des = $_GET["des"];

$sql_apoderados = $conn -> prepare("INSERT into aula(nombre,descripcion) values (?, ?) ");

$sql_apoderados->bind_param("ss", $nom, $des);
$sql_apoderados->execute();
$sql_apoderados->close();
echo json_encode("listo");
?>