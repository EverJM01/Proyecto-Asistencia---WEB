<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");

$sql = $conn -> prepare("DELETE FROM asistencia");
$sql->execute();
$sql->close();
echo json_encode("listo");
?>