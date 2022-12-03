<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");

$inicio = $_GET["inicio"];
$tarde = $_GET["tarde"];
$falta = $_GET["falta"];

$sql = $conn -> prepare("UPDATE horario set hora_inicio = ?, hora_tardanza = ? , hora_final = ? where id = 1");

$sql -> bind_param("sss", $inicio, $tarde, $falta);
$sql -> execute();
$sql -> close();
echo json_encode("listo");
?>