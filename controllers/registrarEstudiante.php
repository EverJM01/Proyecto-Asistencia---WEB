<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");

$doc_nom = $_POST["doc_nom"];
$doc_ape = $_POST["doc_ape"];
$doc_dir = $_POST["doc_dir"];
$doc_nac = $_POST["doc_nac"];
$doc_dni = $_POST["doc_dni"];
$doc_gen = $_POST["doc_gen"];
$doc_aula = $_POST["doc_aula"];

$sql = $conn->prepare("INSERT into estudiante(nombre, apellido, dni, fechanac, genero, foto, direccion, tomado, id_aula) values (?, ?, ?, ?, ?, null, ?, 0, ?) ");
$sql->bind_param('ssssssi', $doc_nom, $doc_ape, $doc_dni, $doc_nac, $doc_gen, $doc_dir, $doc_aula );
$sql->execute();
echo json_encode("listo");
?>