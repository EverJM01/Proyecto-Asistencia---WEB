<?php 
$VISTA_TITULO = 6;
$VISTA_SUBTITULO = 6.3;
$TITULO_PAGINA = 'APODERADOS';
require_once("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/views/admin_header.php"); 


$query_qr = "SELECT e.dni, e.foto, e.nombre, e.apellido, a.nombre
            from estudiante e 
            inner join aula a 
            on a.id = e.id_aula";

if(isset($_GET["idaula_p"])){
      $query_qr = $query_qr." where a.id = ?";
}
?>

<div class="container-fluid px-4">

<div class="row">
            <div class="col-12 col-md-8 divscrollxd ">
                  <div class="mt-2 mb-4">
                        <h2 >Lista de estudiantes registrados</h2>
                        <div class="row mt-3">
                              <div class="col-6">
                                    <p>Elegir aula:</p>
                                    <select name="" id="listaAula" class="form-select rounded-pill" >
                                          <?php 
                                          $sqlaula = $conn->prepare("SELECT id, nombre from aula");
                                          $sqlaula->execute();
                                          $sqlaula->bind_result($idaula_lista, $nombreaula_lista);
                                          while($sqlaula->fetch()){
                                          ?>
                                                <option value="<?=$idaula_lista?>"><?=$nombreaula_lista?></option>      
                                          <?php
                                          }
                                          $sqlaula->close();
                                          ?>
                                    </select>
                              </div>
                              <div class="col-6">
                              <p>Accion:</p>
                              <div class="d-flex">
                                    <button id="btnfiltraraula" class="btn btn-secondary rounded-pill w-50 mx-1"><i class="fa-solid fa-magnifying-glass"></i>  Filtrar</button>
                                    <a role="button" href="/app_asistencia/views/user_adicional_apoderados.php" class="btn btn-success rounded-pill w-50 mx-1"><i class="fa-solid fa-border-all"></i> Todos</a>
                              </div>
                                    
                              </div>
                        </div>
                        
                  </div>
                  <table class="table table-hover p-1 ">
                        <thead>
                              <tr>
                                    <th scope="col">Foto</th>
                                    <th scope="col">DNI</th>
                                    <th scope="col">Nombre completo</th>
                                    <th scope="col">Aula</th>
                                    <th scope="col">Acciones</th>
                              </tr>
                        </thead>
                        <tbody>
                              <?php 
                              $sql = $conn->prepare($query_qr);
                              if(isset($_GET["idaula_p"]) ){
                                    $sql->bind_param("i", $_GET["idaula_p"]);
                              }
                              $sql->execute();
                              $sql->bind_result($dni_est, $foto_est, $nombre_est, $apellido_est, $nombre_aula );
                              while($sql->fetch()){ ?>
                              <tr>
                                    <td>
                                    <?php 
                                    if($foto_est === null){
                                    ?>
                                          <img src="/app_asistencia/src/images/userexample2.jpg" alt="Usuario"  class="imgredonda ">
                                    <?php
                                    }else{
                                    ?>
                                          <img src="data:image/png;base64,<?php echo base64_encode($foto_est) ?>" alt="Foto" id="FT-<?php echo $dni_est ?>"  class="imgredonda">
                                    <?php
                                    }
                                    ?>
                                    </td>
                                    <td><?php echo $dni_est ?></td>
                                    <td><?php echo $nombre_est." ".$apellido_est ?></td>
                                    <td><?php echo $nombre_aula ?></td>
                                    <td>
                                    <div class="d-flex">
                                    <?php 
                                    if($foto_est === null){
                                    ?>
                                          <button disabled type="button" class="btn btn-dark btn-sm rounded-pill mx-1" onclick="mostrarDatosEst(<?php echo $dni_est ?>)"><i class="fa-regular fa-eye"></i></button>
                                    <?php
                                    }else{
                                    ?>
                                          <button type="button" class="btn btn-dark btn-sm rounded-pill mx-1" onclick="mostrarDatosEst(<?php echo $dni_est ?>)"><i class="fa-regular fa-eye"></i></button>

                                    <?php
                                    }
                                    ?>
                                          <button type="button" class="btn btn-secondary btn-sm rounded-pill mx-1"  onclick="mostarDniQr(<?php echo $dni_est ?>)"><i class="fa-solid fa-square-caret-right"></i></button>
                                    </div>
                                    </td>
                              </tr>
                              <?php } $sql->close();?>
                        </tbody>
                  </table>
            </div>
            <div class="col-12 col-md-4 mt-2">
            <h2 class="mb-4">Apoderado</h2>   
            <div class="mb-3">
                  <label for="dni" class="form-label"><i class="fa-solid fa-id-card"></i> Numero DNI del estudiante: </label>
                  <input type="number" id="txtdni" class="form-control fw-bold rounded-pill" required>
            </div>
            <button id="btnapoderados2"  class="btn btn-primary rounded-pill w-100" ><i class="fa-solid fa-square-pen mx-1"></i>Ver apoderado(s)</button>
            <div id="listar_apoderados" class="my-3  justify-content-center" >
            
            </div>
      </div>
</div>

<script src="/app_asistencia/src/js/apoderados.js"></script>

<?php require_once("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/views/admin_footer.php"); ?>

