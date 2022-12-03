<?php 
$VISTA_TITULO = 3;
$VISTA_SUBTITULO = 0;
$TITULO_PAGINA = 'CODIGO QR';
require_once("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/views/admin_header.php"); 

$query_qr = "SELECT e.dni, e.foto, e.nombre, e.apellido, a.nombre
            from estudiante e 
            inner join aula a 
            on a.id = e.id_aula";

if(isset($_GET["idaula_p"])){
      $query_qr = $query_qr." where a.id = ?";
}
?>

<div class="container-fluid px-4 mt-2 ">
      <div class="row">
            <div class="col-12 col-md-8 divscrollxd ">
                  <div class="mt-2 mb-4">
                        <h2 >Lista de estudiantes registrados</h2>
                        <div class="row mt-3">
                              <div class="col-6">
                                    <p>Elegir aula:</p>
                                    <select name="" id="listaAula" class="form-select " >
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
                              <button id="btnfiltraraula" class="btn btn-secondary rounded-pill w-50 mx-1"><i class="fa-solid fa-magnifying-glass "></i>  Filtrar</button>
                                    <a role="button" href="/app_asistencia/views/user_codigoqr.php" class="btn btn-success  w-50 rounded-pill mx-1"><i class="fa-solid fa-border-all"></i> Todos</a>
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
                                          <img src="data:image/png;base64,<?php echo base64_encode($foto_est) ?>" alt="Foto" id="FT-<?php echo $dni_est ?>"  class="imgredonda2">
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
                                          <button disabled type="button" class="btn btn-dark btn-sm mx-1" onclick="mostrarDatosEst(<?php echo $dni_est ?>)"><i class="fa-regular fa-eye"></i></button>
                                    <?php
                                    }else{
                                    ?>
                                          <button type="button" class="btn btn-dark btn-sm mx-1" onclick="mostrarDatosEst(<?php echo $dni_est ?>)"><i class="fa-regular fa-eye"></i></button>
                                    <?php
                                    }
                                    ?>
                                          <button type="button" class="btn btn-secondary btn-sm mx-1"  onclick="mostarDniQr(<?php echo $dni_est ?>)"><i class="fa-solid fa-square-caret-right"></i></button>
                                    </div>
                                    
                                    </td>
                              </tr>
                              <?php } $sql->close();?>
                        </tbody>
                  </table>
            </div>
            <div class="col-12 col-md-4 mt-2">
            <h2 class="mb-4">Generar QR</h2>
                  <form action="#!">
                        <div class="mb-3">
                              <label for="dniqr" class="form-label"><i class="fa-solid fa-id-card"></i> Numero DNI del estudiante: </label>
                              <input type="number" id="txtdniqr" name="_dniqr" class="form-control fw-bold rounded-pill" required>
                        </div>
                        
                        <button id="btngenerarqr" class="btn btn-primary rounded-pill w-100" name="btncrearqr"><i class="fa-solid fa-qrcode"></i> Generar QR</button>

                        <div id="codigoqr_img" class="my-3 d-flex justify-content-center" >
                        </div>
                  </form>
            </div>
      </div>   
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="/app_asistencia/src/js/generarqr.js"></script>


<?php require_once("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/views/admin_footer.php"); ?>