<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");
$userdni = $_GET["dni"];
$nombre = $_GET["nombre"];
$telefono = $_GET["tel"];
$sql_apoderados = $conn -> prepare("UPDATE apoderado a inner join estudiante e on e.id = a.id_estudiante set nom_ape = ?, telefono = ? where e.dni = ?");

$sql_apoderados->bind_param("sss", $nombre, $telefono, $userdni);
$sql_apoderados->execute();
$sql_apoderados->close();
echo json_encode("listo");



?>