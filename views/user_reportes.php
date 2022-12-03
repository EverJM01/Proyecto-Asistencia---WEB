<?php 
$VISTA_TITULO = 4;
$VISTA_SUBTITULO = 0;
$TITULO_PAGINA = 'REPORTES';
require_once("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/views/admin_header.php"); 
?>

<div class="container-fluid px-4">
    <div class="mt-4">
        <h1><i class="fa-solid fa-file-pdf"></i> Generar Reportes</h1>
        <hr>
    </div>
    <div>
        <div class="accordion" id="ac_reportes">
            <div class="accordion-item ">
                <h2 class="accordion-header " id="hd_reporteEst">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ct_reporteEst" aria-expanded="true" aria-controls="ct_reporteEst">
                       <b><i class="fa-solid fa-graduation-cap"></i> Reportes de Estudiantes</b>
                    </button>
                </h2>
                <div id="ct_reporteEst" class="accordion-collapse collapse " aria-labelledby="hd_reporteEst" data-bs-parent="#ac_reportes">
                    <div class="accordion-body">
                        <form id="form_report_est" target="_blank" method="POST" action="/app_asistencia/views/reportes.php?tipo_reporte=E&dni_user=<?=$dniuser?>">
                            <div class="d-flex">
                                <div class="mb-3 w-50 mx-1">
                                    <label for="gen_report_est" class="form-label"><i class="fa-solid fa-user"></i> Elegir genero:</label>
                                    <select class="form-select rounded-pill" name="gen_report_est" id="gen_report_est" >
                                        <option value="T" >Todos</option>    
                                        <option value="M" >Hombre</option>
                                        <option value="F">Mujer</option>
                                    </select>
                                </div>
                                <div class="mb-3 w-50 mx-1">
                                    <label for="aula_report_est" class="form-label"><i class="fa-solid fa-user"></i> Elegir Aula:</label>
                                    <select class="form-select rounded-pill" name="aula_report_est" id="aula_report_est" >
                                        <option value="T" >Todos</option>    
                                        <?php 
                                            $sql = $conn->prepare("SELECT id, nombre FROM aula");
                                            $sql->execute();
                                            $sql->bind_result($aula_id_op, $aula_name_op);
                                            while($sql->fetch()){
                                                ?>
                                                    <option value="<?php echo $aula_id_op ?>"> <?php echo $aula_name_op ?></option>
                                                <?php
                                            }
                                            $sql->close();
                                        ?>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="mb-3 mx-1 d-flex justify-content-center">
                                <button type="submit"  class="btn btn-primary rounded-pill px-5">FIltrar Estudiante</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="hd_reporteDoc">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ct_reporteDoc" aria-expanded="true" aria-controls="ct_reporteDoc">
                       <b><i class="fa-solid fa-school"></i> Reportes de Docentes</b>
                    </button>
                </h2>
                <div id="ct_reporteDoc" class="accordion-collapse collapse " aria-labelledby="hd_reporteDoc" data-bs-parent="#ac_reportes">
                    <div class="accordion-body">
                        <form id="form_report_doc" target="_blank" method="POST" action="/app_asistencia/views/reportes.php?tipo_reporte=D&dni_user=<?=$dniuser?>">
                            <div class="d-flex">
                                <div class="mb-3 w-50 mx-1">
                                    <label for="gen_report_doc" class="form-label"><i class="fa-solid fa-user"></i> Elegir genero:</label>
                                    <select class="form-select rounded-pill" name="gen_report_doc" id="gen_report_doc" >
                                        <option value="T" >Todos</option>    
                                        <option value="M" >Hombre</option>
                                        <option value="F">Mujer</option>
                                    </select>
                                </div>
                                <div class="mb-3 w-50 mx-1">
                                    <label for="aula_report_doc" class="form-label"><i class="fa-solid fa-user"></i> Elegir Aula:</label>
                                    <select class="form-select rounded-pill" name="aula_report_doc" id="aula_report_doc" >
                                        <option value="T" >Todos</option>    
                                        <?php 
                                            $sql = $conn->prepare("SELECT id, nombre FROM aula");
                                            $sql->execute();
                                            $sql->bind_result($aula_id_op, $aula_name_op);
                                            while($sql->fetch()){
                                                ?>
                                                    <option value="<?php echo $aula_id_op ?>"> <?php echo $aula_name_op ?></option>
                                                <?php
                                            }
                                            $sql->close();
                                        ?>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="mb-3 mx-1 d-flex justify-content-center">
                                <button  type="submit"  class="btn btn-primary rounded-pill px-5">FIltrar Docente</button>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="hd_reporteAsis" >
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ct_reporteAsis" aria-expanded="true" aria-controls="ct_reporteAsis">
                       <b><i class="fa-solid fa-calendar-days"></i> Reporte de Asistencias</b>
                    </button>
                </h2>
                <div id="ct_reporteAsis" class="accordion-collapse collapse " aria-labelledby="hd_reporteAsis" data-bs-parent="#ac_reportes">
                    <div class="accordion-body">
                        <form id="form_report_asis" target="_blank" method="POST" action="/app_asistencia/views/reportes.php?tipo_reporte=A&dni_user=<?=$dniuser?>">
                            <div class="d-flex">
                                
                                <div class="mb-3 w-50 mx-1">
                                    <label for="aula_report_asis" class="form-label"> Elegir Aula:</label>
                                    <select class="form-select rounded-pill" name="aula_report_asis" id="aula_report_asis" >
                                        <option value="T" >Todos</option>    
                                        <?php 
                                            $sql = $conn->prepare("SELECT id, nombre FROM aula");
                                            $sql->execute();
                                            $sql->bind_result($aula_id_op, $aula_name_op);
                                            while($sql->fetch()){
                                                ?>
                                                    <option value="<?php echo $aula_id_op ?>"> <?php echo $aula_name_op ?></option>
                                                <?php
                                            }
                                            $sql->close();
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3 w-50 mx-1">
                                    <label for="fecha_report_asis" class="form-label"> Elegir fecha:</label>
                                    <select class="form-select rounded-pill" name="fecha_report_asis" id="fecha_report_asis" >
                                        <option value="T" >Todos</option>    
                                        <?php
                                            $sql = $conn->prepare("SELECT DISTINCT(fecha) FROM asistencia order by fecha desc");
                                            $sql->execute();
                                            $sql->bind_result($fecha_asis);
                                            while($sql->fetch()){
                                                ?>
                                                <option value="<?=$fecha_asis?>" ><?=$fecha_asis?></option>
                                                <?php
                                            }
                                            $sql->close();
                                        ?>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="mb-3 mx-1 d-flex justify-content-center">
                                <button  type="submit"  class="btn btn-primary rounded-pill px-5">FIltrar Asistencia</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="hd_reporteAsis2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ct_reporteAsis2" aria-expanded="true" aria-controls="ct_reporteAsis2">
                       <b><i class="fa-regular fa-calendar-minus"></i> Reporte de Asistencia Individual</b>
                    </button>
                </h2>
                <div id="ct_reporteAsis2" class="accordion-collapse collapse " aria-labelledby="hd_reporteAsis2" data-bs-parent="#ac_reportes">
                    <div class="accordion-body">
                        <form id="form_report_asis2" target="_blank" method="POST" action="/app_asistencia/views/reportes.php?tipo_reporte=A2&dni_user=<?=$dniuser?>">
                            <div class="d-flex">
                               
                                    <div class="mb-3 w-50 mx-1">
                                        <label for="dni_report_asis2" class="form-label">Escribir DNI:</label>
                                        <input required type="number" class="form form-control" name="dni_report_asis2" min="10000000" max="99999999">
                                    </div>
                               
                            </div>
                            <div class="mb-3 mx-1 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary rounded-pill px-5">FIltrar Asistencia Individual</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>
<?php require_once("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/views/admin_footer.php"); ?>