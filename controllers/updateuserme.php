<?php 
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");

$dniuseractual = $_GET["dniuser"];

$sql1=$conn->prepare("UPDATE docente d inner join usuario u on u.id = d.id set 
u.codigo = ?, 
u.pass = ? , 
u.tipo = ?, 
d.nombre = ?, 
d.apellido = ?, 
d.direccion = ?, 
d.fechanac = ?, 
d.telefono = ?, 
d.correo = ?, 
d.dni = ? , 
d.genero = ?, 
d.id_aula = ? where d.dni = ? and u.codigo = ?");
$sql1->bind_param("sssssssssssiss", $_POST["_dni"], 
$_POST["_pass"] , 
$_POST["_tipo"], 
$_POST["_nombre"], 
$_POST["_apellido"], 
$_POST["_direccion"], 
$_POST["_nac"], 
$_POST["_telefono"], 
$_POST["_correo"], 
$_POST["_dni"], 
$_POST["_genero"], 
$_POST["_aula"], $_GET["dniuser"], $_GET["dniuser"]);   
$sql1->execute();
$sql1->close(); 
$conn->close();
echo json_encode ("listoupdate");
?>