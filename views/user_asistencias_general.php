<?php 
$VISTA_TITULO = 2;
$VISTA_SUBTITULO = 2.1;
$TITULO_PAGINA = 'GENERAL';
require_once("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/views/admin_header.php"); 
$sqlfe = $conn->prepare("SELECT MAX(fecha) FROM asistencia");
$sqlfe->execute();
$sqlfe->bind_result($fecha_max);
while($sqlfe->fetch()){
    $fecha_aux = $fecha_max;
}
$sqlfe->close();
if(!isset($_GET["fecha_filtro"])){
    $fechFill = $fecha_aux;
}else{
    $fechFill = $_GET["fecha_filtro"];
}
if(isset($_GET["aula_filtro"])){
    $aulafill = 'AND e.id_aula = '.$_GET["aula_filtro"];
}else{
    $aulafill = ' ';
}
?>

<div class="container-fluid px-4">
    <div class="ms-4 mt-4 mb-4">
        <h1><i class="fa-solid fa-calendar-days"></i> Asistencia General de <?=$fechFill?> </h1>
        <p class="lead">Las faltas se llenan automaticamente en caso no se registren, para los dias feriados es necesario modificarlo manualmente</p>
    </div>
    <hr>
    <div class="d-flex justify-content-center">
      
        <select class="form-select rounded-pill w-50 mx-1" id="filtro_fecha" name="filtro_fecha" required>
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
        
        <select class="form-select rounded-pill w-50 mx-1" id="doc_aula2" name="doc_aula" required>
        <option value="T" >Todos</option>
            <?php
            $sqlaulas = $conn->prepare("Select id, nombre from aula");
            $sqlaulas->execute();
            $sqlaulas->bind_result($id_aula_doc, $nombre_aula_doc);
            while($sqlaulas->fetch()){
                ?>
                <option value="<?=$id_aula_doc?>" ><?=$nombre_aula_doc?></option>
                <?php
            }
            $sqlaulas->close();
            ?>
        </select>
        <button class="btn btn-warning rounded-pill w-50 mx-1" onclick="filtrarCont2()" ><i class="fa-solid fa-magnifying-glass"></i>  filtrar Asistencias</button>
    </div>
    
    <script>
            let direccion_asis = "/app_asistencia/views/user_asistencias_general.php";
            let aux_nm = 0;
            let aulas_fill2 = document.getElementById("doc_aula2");
            function filtrarCont2(){
                    direccion_asis += "?fecha_filtro="+document.getElementById("filtro_fecha").value;
                    if(aulas_fill2.value !== 'T'){
                        direccion_asis += "&aula_filtro="+aulas_fill2.value;
                    }
                    window.location.href=direccion_asis;
            }


        </script>
    <div class="mt-4 px-0">
        <div class="table-responsive">
            <table class="table table-hover" id="tablaDocente">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Foto</th>
                        <th scope="col">DNI</th>
                        <th scope="col">Nombre y apellido</th>
                        <th scope="col">Aula</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Hora</th>
                        <th scope="col">fecha</th>
                        <th scope="col">Justificacion</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $consulta = "SELECT a.*, am.id as idMotivo, am.justificado, am.motivo, am.tipo as tipoAsis, e.dni, e.foto, e.id as idEst, e.nombre as nombreEst, e.apellido, au.nombre, e.id_aula from asistencia a inner join asis_motivo am on am.id_asistencia = a.id inner join estudiante e on e.id = a.id_usuario inner join aula au on au.id = e.id_aula  where a.fecha = ? ".$aulafill;
                        $sqldoce_l= $conn->prepare($consulta);
                        $sqldoce_l->bind_param("s", $fechFill);
                        $sqldoce_l->execute();
                        $resultado_asis = $sqldoce_l->get_result();
                        while($fila_asis= $resultado_asis->fetch_assoc()){
                            ?>
                            <tr class="table-<?php
                                    switch($fila_asis["tipoAsis"]){
                                        case 'F':
                                            echo 'danger';
                                            break;
                                        case 'P':
                                            echo 'primary';  
                                            break;
                                        break;
                                        case 'T':
                                            echo "warning";
                                            break;
                                        case 'X':
                                            echo 'secondary';
                                        break;
                                    } ?>">
                                <th scope="row">
                                <?php 
                                if($fila_asis['foto'] === null){
                                ?>
                                    <img src="/app_asistencia/src/images/userexample2.jpg" alt="Usuario"  class="imgredonda2" >
                                <?php
                                }else{
                                    ?>
                                    <img src="data:image/png;base64,<?php echo base64_encode($fila_asis['foto']) ?>" alt="Foto"  class="imgredonda2">
                                <?php
                                }
                                ?>
                                </th>
                                <td>
                                    <?=$fila_asis["dni"]?>
                                </td>
                                <td>
                                    <?=$fila_asis["nombreEst"]." ".$fila_asis["apellido"]?> 
                                </td>
                                <td>
                                    <?=$fila_asis["nombre"]?>
                                </td>
                                <td >
                                    <div class="d-flex">
                                    <b class="me-1">
                                <?php
                                    switch($fila_asis["tipoAsis"]){
                                        case 'F':
                                            echo 'Falta';
                                            break;
                                        case 'P':
                                            echo 'Puntual';  
                                            break;
                                        break;
                                        case 'T':
                                            echo "Tarde";
                                            break;
                                        case 'X':
                                            echo 'Dia Feriado';
                                        break;
                                    } ?></b><span class="badge bg-<?php
                                    switch($fila_asis["tipoAsis"]){
                                        case 'F':
                                            echo 'danger';
                                            break;
                                        case 'P':
                                            echo 'primary';  
                                            break;
                                        break;
                                        case 'T':
                                            echo "warning";
                                            break;
                                        case 'X':
                                            echo 'secondary';
                                        break;
                                    } ?>"><?php
                                    switch($fila_asis["tipoAsis"]){
                                        case 'F':
                                            echo '<i class="fa-solid fa-face-frown-open"></i>';
                                            break;
                                        case 'P':
                                            echo '<i class="fa-regular fa-face-laugh-wink"></i>';  
                                            break;
                                        break;
                                        case 'T':
                                            echo "<i class='fa-solid fa-face-meh'></i>";
                                            break;
                                        case 'X':
                                            echo '<i class="fa-solid fa-face-grin-tongue-wink"></i>';
                                        break;
                                    } ?></span>
                                
                                    </div>
                                </td>
                                <td>
                                    <?=$fila_asis["hora"]?>
                                </td>
                                <td>
                                    <?=$fila_asis["fecha"]?>
                                </td>
                                <td>
                                    <?php
                                    if($fila_asis["tipoAsis"] == 'F' || $fila_asis["tipoAsis"] == 'T'){
                                        echo '<h5 class="fw-bold">'.$fila_asis["justificado"].'</h5>';
                                    }else{
                                        echo '--';
                                    }
                                    ?>
                                </td>
                                <td>
                                <?php
                                    if($fila_asis["tipoAsis"] == 'F' || $fila_asis["tipoAsis"] == 'T'){
                                       ?>
                                        <button class="btn btn-primary rounded-pill" onclick="editarMotivo(<?=$fila_asis['idMotivo']?>, '<?=$fila_asis['motivo']?>', '<?=$fila_asis['justificado']?>')">Motivo</button>

                                       <?php
                                    }else{
                                        echo '--';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        $sqldoce_l->close();
                    ?>
                </tbody>
            </table> 
        </div>                               
    </div>
</div>

<div id="espacioMotivo">
    <div class="modal fade"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase fw-bold" >  
                    <i class="fa-solid fa-sliders"></i> editar Motivo  
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                   
                        <div class="mb-3">
                            <label  class="form-label"> Motivo</label>
                            <textarea name="motivo_est" class="form-control rounded-0" id="motivo_est"  required></textarea>
                        </div>
                        <div class="form-check form-switch my-3">
                            <input class="form-check-input" type="checkbox" id="swJus">
                            <label class="form-check-label" for="swJus">Justificado</label>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-warning rounded-pill w-50 mx-1" data-bs-dismiss="modal" name="btnCancelar"><i class="fa-regular fa-circle-xmark mx-1"></i> Cancelar</button>
                            <button  class="btn btn-primary rounded-pill w-50 mx-1" id="btnActMot"><i class="fa-solid fa-square-pen mx-1"></i> Actualizar Datos</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const modalEditDoc = document.getElementById("espacioMotivo");
    const namemot = document.getElementById("motivo_est");
    const swjus = document.getElementById("swJus"); 
    const btnActMot = document.getElementById("btnActMot");
    let id_mot;
    const mostrarModalEdit = () => {
        const mod = new bootstrap.Modal(modalEditDoc.querySelector('.modal'));
        mod.show();
    }
    async function editarMotivo(idmotivo, motivo, jus){
        if(jus === 'SI'){
            swjus.checked = true;
        }else{
            swjus.checked = false;
        }

        namemot.value = motivo;
        id_mot=idmotivo;
        mostrarModalEdit();
    }

    btnActMot.addEventListener("click", async ()=>{
        let infojus = '';
        if(swjus.checked){
         infojus = "SI";
        }else{
            infojus = 'NO';
        }
        await fetch("/app_asistencia/controllers/editarMotivo.php?id="+id_mot+"&motivo="+namemot.value+"&jus="+infojus)
        .then( res => res.json())
        .then( data => {
            if(data === 'true'){
                alert("Motivo Cambiado"); 
                location.reload();
            } 
        
        })
    })


</script>
<?php require_once("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/views/admin_footer.php"); ?>