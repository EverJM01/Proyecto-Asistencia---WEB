<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");

$userdni = $_POST["dniuserasis"];

$sql = $conn->query("select id from estudiante where dni='$userdni'");

if ($datos=$sql->fetch_object()) {
      $iduser = $datos -> id;
      $sql = $conn->query("select * from estudiante where id ='$iduser' and tomado=1;");
      if($datos=$sql->fetch_object()){
            echo json_encode('existeAsisUser');  
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
            echo json_encode($datos); 
      }
} else {
      echo json_encode('noexisteUser');  
}    
$sql->close();
$conn -> close();
?>