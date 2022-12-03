<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");

$userdni = $_GET["dniuserasis"];

$sql = $conn->query("select id from estudiante where dni='$userdni'");

if ($datos=$sql->fetch_object()) {
      $iduser = $datos -> id;
      $sql = $conn->query("select * from estudiante where id ='$iduser' and tomado=1;");
      if($datos=$sql->fetch_object()){
            $res = array('respuesta_asis' => 'existeAsisUser');
            
      }else{
            $st = $conn->prepare("call insertarAsis(?)");
            $st->bind_param("i", $iduser);
            $st->execute();
            $st->close();
            $st = $conn->prepare("select validarTipoAsis(?)");
            $st->bind_param("i", $iduser);
            $st->execute();
            $st->bind_result($datos);
            $st->fetch();
            $st->close();
            $res = array('respuesta_asis' => $datos);
      }
} else {
      $res = array('respuesta_asis' => 'noexisteUser');
}   
echo "[".json_encode($res)."]";  
$sql->close();
$conn -> close();
?>