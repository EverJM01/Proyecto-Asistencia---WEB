<?php 
session_start();
session_destroy();
header("Location: /app_asistencia/index.php")
?>