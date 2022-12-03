<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");
$cod = $_POST["doc_dni_set"];
$aula = $_POST["doc_aula_set"];

$nom = $_POST["doc_nom_set"];
$ape = $_POST["doc_ape_set"];

$nac = $_POST["doc_nac_set"];


$gen = $_POST["doc_gen_set"];
$dir = $_POST["doc_dir_set"];

$dnidoc = $_GET["dnidoc"];

$sql2 = $conn -> prepare("UPDATE estudiante set nombre = ?, apellido = ?, direccion = ?, fechanac = ?, dni = ?, genero = ?, id_aula = ?  where dni = ?");

$sql2 -> bind_param("ssssssis", $nom, $ape, $dir, $nac, $cod, $gen, $aula, $dnidoc);
$sql2 -> execute();
$sql2 -> close();

echo json_encode("listo");
?>