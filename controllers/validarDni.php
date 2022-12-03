<?php 
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");

if(isset($_POST["_dni"])){
$userdni = $_POST["_dni"];
}

if(isset($_GET["dni_muestra"])){
$userdni = $_GET["dni_muestra"];
}


$sqluser = $conn->prepare("SELECT * FROM docente WHERE dni = ?");
    
$sqluser->bind_param("s", $userdni);
$sqluser->execute();

if ($sqluser->fetch()) {
      $sqluser->close();
      $conn -> close();
      echo json_encode('truedni');  
} else {
      $sqluser->close();
      $sqluser2 = $conn->prepare("SELECT * FROM estudiante WHERE dni = ?");   
      $sqluser2->bind_param("s", $userdni);
      $sqluser2->execute();
      if ($sqluser2->fetch()) {
            $sqluser2->close();
            $conn -> close();
            echo json_encode('truedni');  
      } else {
            $sqluser2->close();
            $conn -> close();
            echo json_encode('falsedni');  
      }
}
 
    

?>