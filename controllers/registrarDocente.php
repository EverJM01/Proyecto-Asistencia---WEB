<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");

$doc_nom = $_POST["doc_nom"];
$doc_ape = $_POST["doc_ape"];
$doc_dir = $_POST["doc_dir"];
$doc_nac = $_POST["doc_nac"];
$doc_tel = $_POST["doc_tel"];
$doc_corr = $_POST["doc_corr"];
$doc_dni = $_POST["doc_dni"];
$doc_gen = $_POST["doc_gen"];
$doc_aula = $_POST["doc_aula"];

$sql = $conn->prepare("CALL registrarDocente(?,?,?,?,?,?,?,?,?)");
$sql->bind_param('ssssssssi', $doc_nom, $doc_ape, $doc_dir, $doc_nac, $doc_tel, $doc_corr, $doc_dni, $doc_gen, $doc_aula );
$sql->execute();
echo json_encode("listo");
$sql->close();
?>