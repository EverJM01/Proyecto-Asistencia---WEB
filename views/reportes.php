
<?php

include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");
require('./fpdf/fpdf.php');
session_start();
if(empty($_SESSION["id"])){
      header("Location: /app_asistencia/views/login.php");
}else{
    if(isset($_GET["tipo_reporte"]) && isset($_GET["dni_user"])){
        
      
    class PDF extends FPDF{
        
        function Header(){
            $this->Image($_SERVER['DOCUMENT_ROOT'].'\app_asistencia\src\images\user02.jpeg',10,8,23);
            $this->Cell(30);
            $this->SetFont('Arial','',16);
            $this->Cell(137,10,utf8_decode('---- Institución Educativa Capullitos de Amor P.J. ---'),0,0,'C');
            $this->Ln(20);
        }

        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
        }

    }
   

    switch($_GET["tipo_reporte"]){
        case 'E':
            $pdf = new PDF();
            $pdf->AliasNbPages();
            $pdf->AddPage('P');
        
            $pdf->Cell(35);
            $pdf->SetFont('Times','B',13);
            $pdf->Cell(137,10,'TITULO DE REPORTE',1,0,'C');
            $pdf->Ln();
        
            $pdf->Cell(35);
            $pdf->SetFont('Times','',13);
            switch($_GET["tipo_reporte"]){
                case 'E': $pdf->Cell(137,10,'REPORTE DE ESTUDIANTES',1,0,'C');  break;  
        
                case 'D': $pdf->Cell(137,10,'REPORTE DE DOCENTES',1,0,'C'); break; 
                
                case 'A': $pdf->Cell(137,10,'REPORTE DE ASISTENCIA',1,0,'C'); break; 
        
                case 'A2': $pdf->Cell(137,10,'REPORTE DE ASISTENCIA INDIVIDUAL',1,0,'C'); break;  
            }
            $pdf->Ln();
        
            $pdf->Cell(35);
            $pdf->SetFont('Times','B',13);
            $pdf->Cell(73,10,utf8_decode('FECHA DE CREACIÓN'),1,0,'C');
        
            $pdf->SetFont('Times','B',13);
            $pdf->Cell(64,10,utf8_decode('DNI DOC.'),1,0,'C');
            $pdf->Ln();
        
            $pdf->Cell(35);
            $pdf->SetFont('Times','',13);  
            $fecha_actual_reporte = date('m-d-Y h:i:s a', time()); 
            $pdf->Cell(73,10,$fecha_actual_reporte,1,0,'C');
        
            $pdf->SetFont('Times','',13);  
            $pdf->Cell(64,10,$_GET["dni_user"],1,0,'C');
            $pdf->Ln();
        
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(35);
            $pdf->Cell(137,10,"NOMBRE DEL DOCENTE",1,0,'C');
            $pdf->ln();
            
            $pdf->Cell(35);
            $pdf->SetFont('Times','',12);
            $sql = $conn -> prepare("SELECT nombre, apellido FROM docente where dni = ?");
            $sql->bind_param("s", $_GET["dni_user"]);
            $sql->execute();
            $sql->bind_result($nombre_docente, $apellido_docente);
           while($sql->fetch()){
                $pdf->Cell(137,10,strtoupper(utf8_encode(''.$nombre_docente." ".$apellido_docente)),1,0,'C');
            }
            $sql->close();
            $pdf->Ln(20);

            $genero = $_POST["gen_report_est"];
            $aula = $_POST["aula_report_est"];
           
            
            $consulta = "SELECT e.id, e.dni, e.nombre, e.apellido, e.direccion, e.fechanac, e.foto, e.genero, a.nombre, e.id_aula  from estudiante e inner join aula a on a.id = e.id_aula";
            if($genero != 'T' || $aula != 'T'){
                $consulta .= " WHERE  ";
                if($genero != 'T'){
                  
                    $consulta .= " e.genero = '".$genero."' ";
                }
                if($aula != 'T'){
                    if($genero != 'T'){
                        $consulta .= " AND  e.id_aula = ".$aula." ";
                    }else{
                        $consulta .= " e.id_aula = ".$aula." ";
                    }            
                }
            }
    
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(192,10,strtoupper('REGISTRO DE ESTUDIANTES'),0,0,'C');
            $pdf->Ln(15);

            $sql = $conn -> prepare($consulta);
            $sql->execute();
            $sql->bind_result($id_est, $dni_est, $nom_est, $ape_est, $dir_est, $nac_est, $foto_est, $gen_est, $nom_aula, $idaua_est);
            while($sql->fetch()){
               
                $pdf->SetFont('Times','B',11);
                $pdf->Cell(80,10, utf8_decode("Nombre del estudiante"),1,0,'C');
                $pdf->SetFont('Times','',11);
                $pdf->Cell(112,10, strtoupper(utf8_encode($nom_est." \n".$ape_est)),1,0,'C');
                $pdf->Ln();

                $pdf->SetFont('Times','B',11);
                $pdf->Cell(192,8,strtoupper(utf8_decode('INFORMACIÓN DEL ESTUDIANTE')),1,0,'C');
                $pdf->Ln();

                $pdf->SetFont('Times','B',11); 
                $pdf->Cell(30,10,"DNI",1, 0);
                $pdf->SetFont('Times','',11); 
                $pdf->Cell(50,10, utf8_decode($dni_est),1, 0);

                $pdf->SetFont('Times','B',11); 
                $pdf->Cell(50,10,"Aula Ingresada",1, 0);
                $pdf->SetFont('Times','',11); 
                $pdf->Cell(62,10, utf8_decode($nom_aula),1, 0);
                $pdf->Ln();

                $pdf->SetFont('Times','B',11); 
                $pdf->Cell(30,10,"Genero",1, 0);
                $pdf->SetFont('Times','',11); 
                $pdf->Cell(50,10, utf8_decode($gen_est) == 'M' ? 'Masculino':'Femenino',1, 0);

                $pdf->SetFont('Times','B',11); 
                $pdf->Cell(50,10,utf8_decode("Dirección"),1, 0);
                $pdf->SetFont('Times','',11); 
                $pdf->Cell(62,10, utf8_decode($dir_est),1, 0);
                $pdf->Ln();

                $pdf->SetFont('Times','B',11); 
                $pdf->Cell(80,10,"Fecha de nacimiento",1, 0);
                $pdf->SetFont('Times','',12); 
                $pdf->Cell(112,10, utf8_decode($nac_est),1, 0, 'C');
                $pdf->Ln(20);

            }
            $sql->close();

        break;  

        case 'D':
            $pdf = new PDF();
            $pdf->AliasNbPages();
            $pdf->AddPage('P');
        
            $pdf->Cell(35);
            $pdf->SetFont('Times','B',13);
            $pdf->Cell(137,10,'TITULO DE REPORTE',1,0,'C');
            $pdf->Ln();
        
            $pdf->Cell(35);
            $pdf->SetFont('Times','',13);
            switch($_GET["tipo_reporte"]){
                case 'E': $pdf->Cell(137,10,'REPORTE DE ESTUDIANTES',1,0,'C');  break;  
        
                case 'D': $pdf->Cell(137,10,'REPORTE DE DOCENTES',1,0,'C'); break; 
                
                case 'A': $pdf->Cell(137,10,'REPORTE DE ASISTENCIA',1,0,'C'); break; 
        
                case 'A2': $pdf->Cell(137,10,'REPORTE DE ASISTENCIA INDIVIDUAL',1,0,'C'); break;  
            }
            $pdf->Ln();
        
            $pdf->Cell(35);
            $pdf->SetFont('Times','B',13);
            $pdf->Cell(73,10,utf8_decode('FECHA DE CREACIÓN'),1,0,'C');
        
            $pdf->SetFont('Times','B',13);
            $pdf->Cell(64,10,utf8_decode('DNI DOC.'),1,0,'C');
            $pdf->Ln();
        
            $pdf->Cell(35);
            $pdf->SetFont('Times','',13);  
            $fecha_actual_reporte = date('m-d-Y h:i:s a', time()); 
            $pdf->Cell(73,10,$fecha_actual_reporte,1,0,'C');
        
            $pdf->SetFont('Times','',13);  
            $pdf->Cell(64,10,$_GET["dni_user"],1,0,'C');
            $pdf->Ln();
        
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(35);
            $pdf->Cell(137,10,"NOMBRE DEL DOCENTE",1,0,'C');
            $pdf->ln();
            
            $pdf->Cell(35);
            $pdf->SetFont('Times','',12);
            $sql = $conn -> prepare("SELECT nombre, apellido FROM docente where dni = ?");
            $sql->bind_param("s", $_GET["dni_user"]);
            $sql->execute();
            $sql->bind_result($nombre_docente, $apellido_docente);
           while($sql->fetch()){
                $pdf->Cell(137,10,strtoupper(utf8_encode(''.$nombre_docente." ".$apellido_docente)),1,0,'C');
            }
            $sql->close();
            $pdf->Ln(20);

            $genero = $_POST["gen_report_doc"];
            $aula = $_POST["aula_report_doc"];

            $pdf->SetFont('Times','B',12);
            $pdf->Cell(192,10,strtoupper('REGISTRO DE DOCENTES'),0,0,'C');
            $pdf->Ln(15);

            $consulta = "SELECT u.id, u.codigo, d.nombre, d.apellido, d.direccion, d.fechanac, d.telefono, d.correo, d.foto, au.nombre, u.tipo, d.genero, u.pass, d.id_aula from usuario u inner join docente d on d.id = u.id inner join aula au on au.id = d.id_aula";
            if($genero != 'T' || $aula != 'T'){
                $consulta .= " WHERE  ";
                if($genero != 'T'){
                  
                    $consulta .= " d.genero = '".$genero."' ";
                }
                if($aula != 'T'){
                    if($genero != 'T'){
                        $consulta .= " AND  d.id_aula = ".$aula." ";
                    }else{
                        $consulta .= " d.id_aula = ".$aula." ";
                    }            
                }
            }
                $sqldoce_l= $conn->prepare($consulta);
                $sqldoce_l->execute();
                $sqldoce_l->bind_result($id_doc_l, $cod_doc_l, $nom_doc_l, $ape_doc_l, $dir_doc_l, $nac_doc_l, $tel_doc_l, $corr_doc_l, $foto_doc_l, $aula_doc_l, $tipo_doc_l, $gen_doc_l, $pass_doc_l, $idaula_doc_l);

                while($sqldoce_l->fetch()){
                    $pdf->SetFont('Times','B',11);
                    $pdf->Cell(80,10, utf8_decode("Nombre del Docente(a)"),1,0,'C');
                    $pdf->SetFont('Times','',11);
                    $pdf->Cell(112,10, strtoupper(utf8_encode($nom_doc_l." ".$ape_doc_l)),1,0,'C');
                    $pdf->Ln();
    
                    $pdf->SetFont('Times','B',11);
                    $pdf->Cell(192,8,strtoupper(utf8_decode('INFORMACIÓN DEL Docente')),1,0,'C');
                    $pdf->Ln();
    
                    $pdf->SetFont('Times','B',11); 
                    $pdf->Cell(30,10,"DNI",1, 0);
                    $pdf->SetFont('Times','',11); 
                    $pdf->Cell(50,10, utf8_decode($cod_doc_l),1, 0, 'C');
    
                    $pdf->SetFont('Times','B',11); 
                    $pdf->Cell(40,10,"Aula Registrada",1, 0);
                    $pdf->SetFont('Times','',11); 
                    $pdf->Cell(72,10, utf8_decode($aula_doc_l),1, 0, 'C');
                    $pdf->Ln();
    
                    $pdf->SetFont('Times','B',11); 
                    $pdf->Cell(30,10,"Genero",1, 0);
                    $pdf->SetFont('Times','',11); 
                    $pdf->Cell(50,10, utf8_decode($gen_doc_l) == 'M' ? 'Masculino':'Femenino',1, 0, 'C');
    
                    $pdf->SetFont('Times','B',11); 
                    $pdf->Cell(40,10,utf8_decode("Dirección"),1, 0);
                    $pdf->SetFont('Times','',11); 
                    $pdf->Cell(72,10, utf8_decode($dir_doc_l),1, 0, 'C');
                    $pdf->Ln();
    
                    $pdf->SetFont('Times','B',11); 
                    $pdf->Cell(30,10,"Fecha de nac.",1, 0);
                    $pdf->SetFont('Times','',12); 
                    $pdf->Cell(50,10, utf8_decode($nac_doc_l),1, 0, 'C');

                    $pdf->SetFont('Times','B',11); 
                    $pdf->Cell(40,10,"Correo ",1, 0);
                    $pdf->SetFont('Times','',11); 
                    $pdf->Cell(72,10, utf8_decode($corr_doc_l),1, 0, 'C');
                    $pdf->Ln();

                    $pdf->SetFont('Times','B',11); 
                    $pdf->Cell(30,10,"Telefono",1, 0);
                    $pdf->SetFont('Times','',12); 
                    $pdf->Cell(50,10, utf8_decode($tel_doc_l),1, 0, 'C');

                    $pdf->SetFont('Times','B',11); 
                    $pdf->Cell(40,10,"Tipo de usuario",1, 0);
                    $pdf->SetFont('Times','',11); 
                    $pdf->Cell(72,10, utf8_decode($tipo_doc_l) == 'D' ? 'Docente(a)':'Administrador(a)',1, 0, 'C');
                  
                    $pdf->Ln(20);
                }
                $sqldoce_l->close();
            
        break; 

        case 'A':
            $pdf = new PDF();
            $pdf->AliasNbPages();
            $pdf->AddPage('L');
        
            $pdf->Cell(35);
            $pdf->SetFont('Times','B',13);
            $pdf->Cell(137,10,'TITULO DE REPORTE',1,0,'C');
            $pdf->Ln();
        
            $pdf->Cell(35);
            $pdf->SetFont('Times','',13);
            switch($_GET["tipo_reporte"]){
                case 'E': $pdf->Cell(137,10,'REPORTE DE ESTUDIANTES',1,0,'C');  break;  
        
                case 'D': $pdf->Cell(137,10,'REPORTE DE DOCENTES',1,0,'C'); break; 
                
                case 'A': $pdf->Cell(137,10,'REPORTE DE ASISTENCIA',1,0,'C'); break; 
        
                case 'A2': $pdf->Cell(137,10,'REPORTE DE ASISTENCIA INDIVIDUAL',1,0,'C'); break;  
            }
            $pdf->Ln();
        
            $pdf->Cell(35);
            $pdf->SetFont('Times','B',13);
            $pdf->Cell(73,10,utf8_decode('FECHA DE CREACIÓN'),1,0,'C');
        
            $pdf->SetFont('Times','B',13);
            $pdf->Cell(64,10,utf8_decode('DNI DOC.'),1,0,'C');
            $pdf->Ln();
        
            $pdf->Cell(35);
            $pdf->SetFont('Times','',13);  
            $fecha_actual_reporte = date('m-d-Y h:i:s a', time()); 
            $pdf->Cell(73,10,$fecha_actual_reporte,1,0,'C');
        
            $pdf->SetFont('Times','',13);  
            $pdf->Cell(64,10,$_GET["dni_user"],1,0,'C');
            $pdf->Ln();
        
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(35);
            $pdf->Cell(137,10,"NOMBRE DEL DOCENTE",1,0,'C');
            $pdf->ln();
            
            $pdf->Cell(35);
            $pdf->SetFont('Times','',12);
            $sql = $conn -> prepare("SELECT nombre, apellido FROM docente where dni = ?");
            $sql->bind_param("s", $_GET["dni_user"]);
            $sql->execute();
            $sql->bind_result($nombre_docente, $apellido_docente);
           while($sql->fetch()){
                $pdf->Cell(137,10,strtoupper(utf8_encode(''.$nombre_docente." ".$apellido_docente)),1,0,'C');
            }
            $sql->close();
            $pdf->Ln(20);
            $aula = $_POST["aula_report_asis"];
            $fecha = $_POST["fecha_report_asis"];

            $pdf->SetFont('Times','B',11);
            $pdf->Cell(280,10,strtoupper('REGISTRO DE ASISTENCIA'),1,0,'C');
            $pdf->Ln();
            $pdf->SetFont('Times','B',10); 
            $pdf->Cell(8,8, utf8_decode("N°"),1, 0);
            $pdf->Cell(20,8, utf8_decode("Fecha"),1, 0, 'C');
            $pdf->Cell(50,8, utf8_decode("Nombre"),1, 0, 'C');
            $pdf->Cell(20,8, utf8_decode("DNI"),1, 0, 'C');
            $pdf->Cell(45,8, utf8_decode("Aula"),1, 0, 'C');
            $pdf->Cell(10,8, utf8_decode("Tipo"),1, 0, 'C');
            $pdf->Cell(15,8, utf8_decode("Hora"),1, 0, 'C');
            $pdf->Cell(10,8, utf8_decode("Jus."),1, 0, 'C');
            $pdf->Cell(102,8, utf8_decode("Motitvo"),1, 0, 'C');
            $pdf->Ln();

            $pdf->SetFont('Times','',10); 
            $consulta = "SELECT a.*, am.id as idMotivo, am.justificado, am.motivo, am.tipo as tipoAsis, e.dni, e.foto, e.id as idEst, e.nombre as nombreEst, e.apellido, au.nombre, e.id_aula from asistencia a inner join asis_motivo am on am.id_asistencia = a.id inner join estudiante e on e.id = a.id_usuario inner join aula au on au.id = e.id_aula ";
            if($aula != 'T' || $fecha != 'T'){
                $consulta .= " WHERE  ";
                if($fecha != 'T'){
                    $consulta .= " a.fecha = '".$fecha."' ";
                }
                if($aula != 'T'){
                    if($fecha != 'T'){
                        $consulta .= " AND  e.id_aula = ".$aula." ";
                    }else{
                        $consulta .= " e.id_aula = ".$aula." ";
                    }            
                }
            }
            
            
            
            
            $sqldoce_l= $conn->prepare($consulta);
            $sqldoce_l->execute();
            $resultado_asis = $sqldoce_l->get_result();
            $num = 0;
            while($fila_asis= $resultado_asis->fetch_assoc()){
                $num++;
                $pdf->Cell(8,8, utf8_decode($num),1, 0);
                $pdf->Cell(20,8, utf8_decode($fila_asis["fecha"]),1, 0, 'C');
                $pdf->Cell(50,8, utf8_decode($fila_asis["nombreEst"]),1, 0, 'C');
                $pdf->Cell(20,8, utf8_decode($fila_asis["dni"]),1, 0, 'C');
                $pdf->Cell(45,8, utf8_decode($fila_asis["nombre"]),1, 0, 'C');
                $pdf->Cell(10,8, utf8_decode($fila_asis["tipoAsis"]),1, 0, 'C');
                $pdf->Cell(15,8, utf8_decode($fila_asis["hora"]),1, 0, 'C');
                $pdf->Cell(10,8, utf8_decode($fila_asis["justificado"]),1, 0, 'C');
                $pdf->Cell(102,8, utf8_decode($fila_asis["motivo"]),1, 0, 'C');
                $pdf->Ln();
            }
            $sqldoce_l->close();
        break; 

        case 'A2':
            $pdf = new PDF();
            $pdf->AliasNbPages();
            $pdf->AddPage('L');
        
            $pdf->Cell(35);
            $pdf->SetFont('Times','B',13);
            $pdf->Cell(137,10,'TITULO DE REPORTE',1,0,'C');
            $pdf->Ln();
        
            $pdf->Cell(35);
            $pdf->SetFont('Times','',13);
            switch($_GET["tipo_reporte"]){
                case 'E': $pdf->Cell(137,10,'REPORTE DE ESTUDIANTES',1,0,'C');  break;  
        
                case 'D': $pdf->Cell(137,10,'REPORTE DE DOCENTES',1,0,'C'); break; 
                
                case 'A': $pdf->Cell(137,10,'REPORTE DE ASISTENCIA',1,0,'C'); break; 
        
                case 'A2': $pdf->Cell(137,10,'REPORTE DE ASISTENCIA INDIVIDUAL',1,0,'C'); break;  
            }
            $pdf->Ln();
        
            $pdf->Cell(35);
            $pdf->SetFont('Times','B',13);
            $pdf->Cell(73,10,utf8_decode('FECHA DE CREACIÓN'),1,0,'C');
        
            $pdf->SetFont('Times','B',13);
            $pdf->Cell(64,10,utf8_decode('DNI DOC.'),1,0,'C');
            $pdf->Ln();
        
            $pdf->Cell(35);
            $pdf->SetFont('Times','',13);  
            $fecha_actual_reporte = date('m-d-Y h:i:s a', time()); 
            $pdf->Cell(73,10,$fecha_actual_reporte,1,0,'C');
        
            $pdf->SetFont('Times','',13);  
            $pdf->Cell(64,10,$_GET["dni_user"],1,0,'C');
            $pdf->Ln();
        
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(35);
            $pdf->Cell(137,10,"NOMBRE DEL DOCENTE",1,0,'C');
            $pdf->ln();
            
            $pdf->Cell(35);
            $pdf->SetFont('Times','',12);
            $sql = $conn -> prepare("SELECT nombre, apellido FROM docente where dni = ?");
            $sql->bind_param("s", $_GET["dni_user"]);
            $sql->execute();
            $sql->bind_result($nombre_docente, $apellido_docente);
           while($sql->fetch()){
                $pdf->Cell(137,10,strtoupper(utf8_encode(''.$nombre_docente." ".$apellido_docente)),1,0,'C');
            }
            $sql->close();
            $pdf->Ln(20);
            $dni = $_POST["dni_report_asis2"];

            
            $pdf->SetFont('Times','B',11);
            $pdf->Cell(280,10,strtoupper('REGISTRO DE ASISTENCIA'),1,0,'C');
            $pdf->Ln();
            $pdf->SetFont('Times','B',10); 
            $pdf->Cell(8,8, utf8_decode("N°"),1, 0);
            $pdf->Cell(20,8, utf8_decode("Fecha"),1, 0, 'C');
            $pdf->Cell(50,8, utf8_decode("Nombre"),1, 0, 'C');
            $pdf->Cell(20,8, utf8_decode("DNI"),1, 0, 'C');
            $pdf->Cell(45,8, utf8_decode("Aula"),1, 0, 'C');
            $pdf->Cell(10,8, utf8_decode("Tipo"),1, 0, 'C');
            $pdf->Cell(15,8, utf8_decode("Hora"),1, 0, 'C');
            $pdf->Cell(10,8, utf8_decode("Jus."),1, 0, 'C');
            $pdf->Cell(102,8, utf8_decode("Motitvo"),1, 0, 'C');
            $pdf->Ln();

            $pdf->SetFont('Times','',10); 
            $consulta = "SELECT a.*, am.id as idMotivo, am.justificado, am.motivo, am.tipo as tipoAsis, e.dni, e.foto, e.id as idEst, e.nombre as nombreEst, e.apellido, au.nombre, e.id_aula from asistencia a inner join asis_motivo am on am.id_asistencia = a.id inner join estudiante e on e.id = a.id_usuario inner join aula au on au.id = e.id_aula where e.dni =  ".$dni;
   
            $sqldoce_l= $conn->prepare($consulta);
            $sqldoce_l->execute();
            $resultado_asis = $sqldoce_l->get_result();
            $num = 0;
            while($fila_asis= $resultado_asis->fetch_assoc()){
                $num++;
                $pdf->Cell(8,8, utf8_decode($num),1, 0);
                $pdf->Cell(20,8, utf8_decode($fila_asis["fecha"]),1, 0, 'C');
                $pdf->Cell(50,8, utf8_decode($fila_asis["nombreEst"]),1, 0, 'C');
                $pdf->Cell(20,8, utf8_decode($fila_asis["dni"]),1, 0, 'C');
                $pdf->Cell(45,8, utf8_decode($fila_asis["nombre"]),1, 0, 'C');
                $pdf->Cell(10,8, utf8_decode($fila_asis["tipoAsis"]),1, 0, 'C');
                $pdf->Cell(15,8, utf8_decode($fila_asis["hora"]),1, 0, 'C');
                $pdf->Cell(10,8, utf8_decode($fila_asis["justificado"]),1, 0, 'C');
                $pdf->Cell(102,8, utf8_decode($fila_asis["motivo"]),1, 0, 'C');
                $pdf->Ln();
            }
            $sqldoce_l->close();
        break;  
    }

    $pdf->Output();
        
        

    }
}



?>