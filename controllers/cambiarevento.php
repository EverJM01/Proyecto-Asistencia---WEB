<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");
$es = $_GET["estado"];

$sql = $conn -> prepare("SET GLOBAL event_scheduler=?");
$sql->bind_param("s",  $es);
$sql->execute();
$sql->close();

echo json_encode("listo");
?>