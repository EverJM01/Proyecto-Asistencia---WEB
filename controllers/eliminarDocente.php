<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");
$id = $_GET["iddoce"];

$sql = $conn -> prepare("DELETE FROM docente WHERE id = ?");
$sql->bind_param("i",  $id);
$sql->execute();
$sql->close();

echo json_encode("listo");
?>