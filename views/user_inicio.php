<?php 
$VISTA_TITULO = 0;
$VISTA_SUBTITULO = 0;
$TITULO_PAGINA = 'INICIO';
require_once("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/views/admin_header.php"); 

$sql = $conn->query("select * from horario where id=1");
$hora_1 = null;
$hora_2 = null;
$hora_3 = null;

if($datos = $sql->fetch_object()){
  $hora_1 = date_format(date_create($datos->hora_inicio), "H:i");
  $hora_2 = date_format(date_create($datos->hora_tardanza), "H:i");
  $hora_3 = date_format(date_create($datos->hora_final), "H:i");
}

?>

<div class="container-fluid px-4">
    <div class="row">
        <h1 class="mt-4 col-8">
                <?php                           
                $horactual = date('H:i', time());  
        
                $horausermañana = date_format(date_create('05:00'), "H:i");
                $horausertarde = date_format(date_create('12:00'), "H:i");
                $horausernoche = date_format(date_create('18:00'), "H:i");
                echo $saludo = (
                ($horactual <= $horausermañana || $horactual > $horausernoche) ? '<i class="fa-solid fa-cloud-moon"></i> Buenas Noches, ' : 
                (($horactual <= $horausertarde) ? '<i class="fa-solid fa-mug-saucer"></i> Buenos Dias, ' : 
                (($horactual <= $horausernoche) ? '<i class="fa-solid fa-mountain-sun"></i> Buenas Tardes, ' : 
                'Bienvenido ' )));
                if($tipouser === 'A'){
                    echo $generouser === 'F' ? 'Administradora' : 'Administrador';
                }
                if($tipouser === 'D'){
                    echo $generouser === 'F' ? 'Profesora' : 'Profesor';
                } 
            ?>
        </h1> 
        <h3 class="mb-4 fw-light">
            Bienvenido <?php echo $nombreuser ?> al sistema de asistencia
        </h3>
    </div>
    <div class="row">
        <div class="col-12 col-lg-4  mb-4 ">
            <div class="d-none d-lg-block">
                <p class="lead fw-bold">
                    <i class="fa-regular fa-calendar-check"></i> 
                    Horario Actual 
                    <?php if($tipouser === 'A'){ ?>
                    <a href="/app_asistencia/views/user_adicional_horario.php" class="btn btn-success btn-sm ms-1 rounded-pill px-3" ><i class="fa-regular fa-pen-to-square"></i> Editar</a>
                    <?php } ?>
                </p>
                <table class="table table-hover table-success ">
                    <tr>
                        <th scope="col"><i class="fa-solid fa-stopwatch"></i> Temprano</th>
                        <td>Hasta  <?php echo $hora_1 ?></td>
                    </tr>
                    <tr>
                        <th scope="col"><i class="fa-solid fa-hourglass-half"></i> Tardanza</th>
                        <td>Hasta  <?php echo $hora_2 ?></td>
                    </tr>
                    <tr>
                        <th scope="col"><i class="fa-regular fa-hourglass"></i> Falta</th>
                        <td>Hasta  <?php echo $hora_3 ?></td>
                    </tr>
                </table> 
            </div>
            
        </div>
        <div class="col-12 col-lg-8">
    

        </div>
    </div>
    
    <div class="mb-4 ">
        <p class="lead fw-bold text-center">Seleccione que desea hacer</p>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-6">
            <div class="menucard-1 cardme" id="item1">
                <h3>Estudiantes</h3>
                <p>Lista de estudiantes en el sistema</p>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 col-xl-6 ">
            <div class="menucard-2 cardme" id="item2">
                <h3>Asistencias</h3>
                <p>Administrar las asistencias tomadas</p>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 col-xl-6 ">
            <div class="menucard-5 cardme" id="item5">
                <h3>Codigo QR</h3>
                <p>Generar codigo qr de estudiante</p>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 col-xl-6 ">
            <div class="menucard-6 cardme" id="item6">
                <h3>Reportes</h3>
                <p>Crear reportes de la informacion alamacenada</p>
            </div>
        </div>
        <?php
         if($tipouser === 'A'){
        ?>
        <div class="col-md-12 col-lg-12 col-xl-6 ">
            <div class="menucard-7 cardme" id="item7">
                <h3>Docentes</h3>
                <p>Administrar los docentes registrados</p>
            </div>
        </div>
        
        <div class="col-md-12 col-lg-12 col-xl-6 ">
            <div class="menucard-8 cardme" id="item8">
                <h3>Horario</h3>
                <p>Configurar el Horario</p>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 col-xl-6 ">
            <div class="menucard-9 cardme" id="item9">
                <h3>Aulas</h3>
                <p>Configurar aulas resgistradas</p>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 col-xl-6 ">
            <div class="menucard-10 cardme" id="item10">
                <h3>Apoderados</h3>
                <p>Configuracion de apoderados</p>
            </div>
        </div>
        <?php } ?>
    </div>
</div>




<script src="/app_asistencia/src/js/<?=$tipouser == 'A' ? 'admin_inicio' : 'admin_inicio_D'?>.js"></script>

<?php require_once("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/views/admin_footer.php"); ?>

                    
                