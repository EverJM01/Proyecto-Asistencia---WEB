<?php
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");

$userdni = $_POST["userdni"];
$userpass = $_POST["userpass"];

$sql = $conn->query("select * from usuario where codigo='$userdni' and pass='$userpass'");

if ($datos=$sql->fetch_object()) {
      echo json_encode($datos);  
} else {
      echo json_encode('falseUser');  
}    
$conn -> close();
?>