<?php 
include("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");  

if(!isset($_GET["iduser"], $_GET["coduser"], $_GET["passuser"])){
      echo "<center>";
      echo "<h1>Lo sentimos, no se encontro los datos del usuario :c</h1><h2>Acceso restringido</h2>";
      echo "<a href='/app_asistencia/index.php'>Volver a login</a>";
      echo "</center>";
      return;
}

session_start();

$iduser = $_GET["iduser"];
$coduser = $_GET["coduser"];
$passuser = $_GET["passuser"];

$sql = $conn->query("select * from usuario where codigo='$coduser' and pass='$passuser' and id='$iduser'");
if ($datos=$sql->fetch_object()) {
      $_SESSION["id"]=$datos->id;
      header("Location: /app_asistencia/views/user_inicio.php");
} 
$conn -> close();
?>
