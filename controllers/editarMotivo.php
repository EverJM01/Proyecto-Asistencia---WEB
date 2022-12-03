<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");
$id = $_GET["id"];
$mot = $_GET["motivo"];
$jus = $_GET["jus"];

$sql = $conn -> prepare("UPDATE asis_motivo SET motivo = ?, justificado = ? where id = ? ");
$sql->bind_param("ssi", $mot, $jus,$id);
$sql->execute();
$sql->close();
echo json_encode("true");
?>