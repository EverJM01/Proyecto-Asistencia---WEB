<?php 
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");
$userdni = $_GET["dni"];
$sql_apoderados = $conn -> prepare("SELECT a.id, a.nom_ape, a.telefono, e.id from apoderado a inner join estudiante e on e.id = a.id_estudiante where e.dni = ? ");
$sql_apoderados->bind_param("s", $userdni);
$sql_apoderados->execute();
$sql_apoderados->bind_result($id_apo, $nom_apo, $tel_apo, $id_est);
if($sql_apoderados->fetch()){
    $datos_apo = array($id_apo, $nom_apo, $tel_apo, $id_est, "listo");
    $sql_apoderados->close();
    echo json_encode($datos_apo);
}else{
    $sql_apoderados2 = $conn -> prepare("SELECT id from estudiante where dni = ? ");
    $sql_apoderados2->bind_param("s", $userdni);
    $sql_apoderados2->execute();
    $sql_apoderados2->bind_result($id_est);
    if($sql_apoderados2->fetch()){
        $datos_apo2= array($id_est, "no listo");
         $sql_apoderados2->close();
        echo json_encode($datos_apo2);
    }
    
   
}


?>