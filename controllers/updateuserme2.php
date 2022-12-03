<?php 
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");

$dniuseractual = $_GET["dniuser"];

$sql1=$conn->prepare("UPDATE docente d inner join usuario u on u.id = d.id set 
u.pass = ? , 
d.direccion = ?, 
d.fechanac = ?, 
d.telefono = ?, 
d.correo = ?, 
d.genero = ?
 where d.dni = ? and u.codigo = ?");
$sql1->bind_param("ssssssss", 
$_POST["_pass"] ,  
$_POST["_direccion"], 
$_POST["_nac"], 
$_POST["_telefono"], 
$_POST["_correo"], 
$_POST["_genero"], 
 $_GET["dniuser"], $_GET["dniuser"]);   
$sql1->execute();
$sql1->close(); 
$conn->close();
echo json_encode ("listoupdate");
?>