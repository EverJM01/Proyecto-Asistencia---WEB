<?php 
session_start();
if(!empty($_SESSION["id"])){
      header("Location: /app_asistencia/views/user_inicio.php");
}else{
      require_once($_SERVER['DOCUMENT_ROOT']."/app_asistencia/controllers/loginController.php");
      $template = new LoginController();
      $template -> getTemplate();  
}
?>