<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");
$cod = $_POST["doc_dni_set"];
$aula = $_POST["doc_aula_set"];
$tipo = $_POST["doc_tipo_set"];
$nom = $_POST["doc_nom_set"];
$ape = $_POST["doc_ape_set"];
$pass = $_POST["doc_pass_set"];
$nac = $_POST["doc_nac_set"];
$tel = $_POST["doc_tel_set"];
$corr = $_POST["doc_corr_set"];
$gen = $_POST["doc_gen_set"];
$dir = $_POST["doc_dir_set"];

$dnidoc = $_GET["dnidoc"];

$sql = $conn -> prepare("UPDATE usuario  set codigo = ?, pass = ?, tipo = ?  where codigo = ?");

$sql -> bind_param("ssss", $cod, $pass, $tipo, $dnidoc);
$sql -> execute();
$sql -> close();

$sql2 = $conn -> prepare("UPDATE docente  set nombre = ?, apellido = ?, direccion = ?, fechanac = ?, telefono = ?, correo = ?, dni = ?, genero = ?, id_aula = ?  where dni = ?");

$sql2 -> bind_param("ssssssssis", $nom, $ape, $dir, $nac, $tel, $corr, $cod, $gen, $aula, $dnidoc);
$sql2 -> execute();
$sql2 -> close();

echo json_encode("listo");
?>