<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");
$id = $_GET["id"];
$sql = $conn -> prepare("DELETE FROM aula where id = ? ");
$sql->bind_param("i", $id);
$sql->execute();
$sql->close();
header("Location: /app_asistencia/views/user_adicional_aulas.php");
?>