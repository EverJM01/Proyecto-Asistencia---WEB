<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");
$id = $_GET["btnidaula"];
$nom = $_GET["nom_a"];
$des = $_GET["des_a"];
$sql = $conn -> prepare("UPDATE aula SET nombre = ?, descripcion = ? where id = ? ");
$sql->bind_param("ssi", $nom, $des, $id);
$sql->execute();
$sql->close();
header("Location: /app_asistencia/views/user_adicional_aulas.php");
?>