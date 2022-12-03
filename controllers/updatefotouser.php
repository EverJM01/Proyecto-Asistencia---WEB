<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");

$tipoupfoto = $_GET["tipouserfoto"];
$dniuserfoto = $_GET["dni"];
 if($tipoupfoto === '1'){
      if(isset($_FILES["archivofoto"])){
            $imagenxd = $_FILES['archivofoto']['tmp_name'];
            $imgcontenido = addslashes(file_get_contents($imagenxd));
            $conn->query("UPDATE docente set foto = '$imgcontenido' where dni = '$dniuserfoto'");
            $conn -> close();
            echo json_encode("actualizadosi");
      }else{
            echo json_encode("actualizadono");  
      }
      
 }

 if($tipoupfoto === '0'){
      $conn->query("UPDATE docente set foto = null where dni = '$dniuserfoto'");
      $conn -> close();
      echo json_encode("eliminadosi");
}
?>