<?php
include("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php"); 
if(isset($_GET["dnistudent"])){
    $dni_show_student = $_GET["dnistudent"];
    $sql=$conn->query("SELECT nombre, apellido, TO_BASE64(foto) FROM estudiante WHERE dni = '$dni_show_student'");
    if($datos = $sql->fetch_array()){
        $datos_show_student[] = array_map("utf8_encode",$datos);
    }
    echo json_encode($datos_show_student);
    $sql->close();
    $conn->close();
}else{
    echo json_encode("ERROR-RS");
} 

?>