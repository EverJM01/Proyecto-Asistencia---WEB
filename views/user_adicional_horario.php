<?php 
$VISTA_TITULO = 6;
$VISTA_SUBTITULO = 6.1;
$TITULO_PAGINA = 'HORARIO';
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
    <div class="mt-2">
        <h1><i class="fa-solid fa-calendar-day"></i> Configurar Horario</h1>
        <p class="lead">Para configurar el tiempo utilize el formato de 24 horas </p>
        <hr>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="p-0 p-lg-5">
                    <div class="mb-5">
                    <p class="lead fw-bold"><i class="fa-solid fa-calendar-check"></i> Hora limite para Temprano: </p>
                    <input type="time" class="form-control rounded-pill" id="hora_tempranox">
                    </div>
                    <div class="my-5 ">
                    <p class="lead fw-bold"><i class="fa-solid fa-calendar-minus"></i> Hora limite para Tardanza: </p>
                        <input type="time" class="form-control rounded-pill" id="hora_tardanzax">
                    </div>
                    <div class="my-5">
                    <p class="lead fw-bold"><i class="fa-solid fa-calendar-xmark"></i> Hora limite para Falta: </p>
                        <input type="time" class="form-control rounded-pill" id="hora_faltax">
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-secondary rounded-pill w-50 py-2 mx-1" id="btnLimpiarx"><i class="fa-solid fa-trash-can"></i> Limpiar</button>
                        <button class="btn btn-success rounded-pill w-50 py-2 mx-1" id="btnEstablecerx"><i class="fa-regular fa-thumbs-up"></i> Establecer</button>
                    </div>
                </div>
               
                
            </div>
            <div class="col-12 col-md-6 p-3">
                <h2>Horario Actual</h2>
                <div class=" p-0 p-lg-5">

                <table class="table table-hover table-warning">
                    <tr>
                        <th scope="col"><i class="fa-solid fa-stopwatch"></i> Temprano</th>
                        <td><?php echo $hora_1 ?></td>
                    </tr>
                    <tr>
                        <th scope="col"><i class="fa-solid fa-hourglass-half"></i> Tardanza</th>
                        <td><?php echo $hora_2 ?></td>
                    </tr>
                    <tr>
                        <th scope="col"><i class="fa-regular fa-hourglass"></i> Falta</th>
                        <td><?php echo $hora_3 ?></td>
                    </tr>
                </table> 
                 </div>
                 <div>
                    <?php
                    $sqlevent = $conn->prepare("SELECT @@global.event_scheduler as valor_evento_horario_global");
                  
                    $sqlevent->execute();
                    $result_event = $sqlevent->get_result();
                    $fila_event= $result_event->fetch_assoc()
                    ?>
                   
                   <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" onchange="cambiarestadohorario()" <?=$fila_event['valor_evento_horario_global'] == 'ON' ? 'checked' : ''?>>
                        <label class="form-check-label" for="flexSwitchCheckDefault">Activar/Desactivar Horario </label>
                    </div>
                    <div class="my-3">
                        <h5 class="text-<?=$fila_event['valor_evento_horario_global'] == 'ON' ? 'success' : 'danger'?>">El horario esta <?=$fila_event['valor_evento_horario_global'] == 'ON' ? 'activado' : 'desactivado'?></h5>
                    </div>
                    <div class="my-3">
                        <p class=" text-sm-left">**Activar o desactivar para la temporada de vacaciones o dias feriados, sino automaticamente se marcara faltas innecesarias</p>
                    </div>
                </div>
                    <?php  $sqlevent->close()?>

                    <script>
                        let estadoactual = '<?=$fila_event['valor_evento_horario_global']?>';
                        async function cambiarestadohorario(){
                            
                            if(estadoactual === 'ON'){
                                estadoactual = 'OFF'
                            }else{
                                estadoactual = 'ON'
                            }
                            await fetch("/app_asistencia/controllers/cambiarevento.php?estado="+estadoactual)
                            .then( res => res.json())
                            .then( data => {
                                    if(data === 'listo'){
                                        alert("Cambio exitoso, estado: " + (estadoactual == 'ON' ? 'Activado' : 'Desactivado')); 
                                        location.reload()
                                    }
                            })
                        }
                    </script>
                    <div>
                        <button class="btn btn-danger" onclick="eliminarAsis()"><i class="fa-solid fa-triangle-exclamation"></i> ELIMINAR ASISTENCIAS</button>
                    </div>
            </div>
        </div>
        
        <script>
            async function eliminarAsis(){
                let confAsis = confirm("¿Desea Eliminar Las Asistencias?");
                if(!confAsis){
                    return;
                }
                await fetch("/app_asistencia/controllers/eliminarAsis.php")
                .then( res => res.json())
                .then( data => {
                        if(data === 'listo'){
                            alert("Borrado Exitoso"); 
                        
                        }
                })
            }
        </script>
        
    </div>
</div>
<script src="/app_asistencia/src/js/horario.js"></script>
<?php require_once("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/views/admin_footer.php"); ?>