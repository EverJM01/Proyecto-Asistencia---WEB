<?php 
$VISTA_TITULO = 5;
$VISTA_SUBTITULO = 0;
$TITULO_PAGINA = 'DOCENTES';
require_once("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/views/admin_header.php"); 
?>

<div class="container-fluid px-4">
    <div class="ms-4 mt-4 mb-4">
        <h1><i class="fa-solid fa-chalkboard-user"></i> Configurar Docentes</h1>
    </div>
    
    <div class="accordion mt-4 mb-4"  id="accorReDoc">
        <div class="accordion-item ">
            <div class="accordion-header" id="headingOne">
                <button class="btn btn-outline-primary w-100 py-0 " type="button" data-bs-toggle="collapse" data-bs-target="#collapseFormCrearDoc" aria-expanded="true" aria-controls="collapseOne">
                    <h5 class="pt-1"><i class="fa-regular fa-square-plus"></i> Registrar Nuevo Docente</h5>
                </button>
            </div>
            <div id="collapseFormCrearDoc" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <form id="formCrearDoc">
                    <div class="row mt-2">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="my-3">
                                <label for="doc_nom"><i class="fa-solid fa-file-signature"></i> Nombre</label>
                                <input type="text" class="form-control rounded-pill" id="doc_nom" name="doc_nom" required>
                            </div>
                            <div class="my-3">
                                <label for="doc_ape"><i class="fa-regular fa-circle"></i> Apellido</label>
                                <input type="text" class="form-control rounded-pill" id="doc_ape" name="doc_ape" required>
                            </div>
                            <div class="my-3">
                                <label for="doc_dir"><i class="fa-solid fa-map-location-dot"></i> Direccion</label>
                                <input type="text" class="form-control rounded-pill" id="doc_dir" name="doc_dir" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="my-3">
                                <label for="doc_nac"><i class="fa-solid fa-baby-carriage"></i> Fecha de nacimiento</label>
                                <input type="date" class="form-control rounded-pill" id="doc_nac" name="doc_nac" required>
                            </div>
                            <div class="my-3">
                                <label for="doc_corr"><i class="fa-regular fa-envelope"></i> Correo</label>
                                <input type="email" class="form-control rounded-pill" id="doc_corr" name="doc_corr" required>
                            </div>
                            <div class="my-3">
                                <label for="doc_dni"><i class="fa-solid fa-id-card"></i> DNI</label>
                                <input type="number" class="form-control rounded-pill" id="doc_dni" name="doc_dni" required>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="my-3">
                                <label for="doc_tel"><i class="fa-solid fa-phone"></i> Telefono</label>
                                <input type="number" class="form-control rounded-pill" id="doc_tel" name="doc_tel" required>
                            </div>
                            <div class="my-3">
                                <label for="doc_gen"><i class="fa-solid fa-person-half-dress"></i> Genero</label>
                                <select class="form-select rounded-pill" id="doc_gen" name="doc_gen" required>
                                    <option value="M" >Hombre</option>
                                    <option value="F" selected>Mujer</option>
                                </select>
                            </div>
                            <div class="my-3">
                                <label for="doc_aula"><i class="fa-solid fa-school-circle-check"></i> Aula</label>
                                <select class="form-select rounded-pill" id="doc_aula" name="doc_aula" required>
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
                            </div>
                        </div>  
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success rounded-pill mx-1 px-5"><i class="fa-solid fa-circle-plus"></i>  Crear Docente</button>
                        <button class="btn btn-secondary rounded-pill mx-1 px-5" id="btnlimpiarDoc" ><i class="fa-solid fa-broom"></i>  Limpiar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4 d-flex justify-content-center">
        <h4> Lista de docentes registrados</h4>
    </div>
    <?php
    $aux = 0;
    $queryDoc = "SELECT u.id, u.codigo, d.nombre, d.apellido, d.direccion, d.fechanac, d.telefono, d.correo, d.foto, au.nombre, u.tipo, d.genero, u.pass, d.id_aula from usuario u inner join docente d on d.id = u.id inner join aula au on au.id = d.id_aula";
    if(isset($_GET["dni_f"]) || isset($_GET["aula_f"]) || isset($_GET["gen_f"])){
        $queryDoc .= " WHERE ";
        
        if(isset($_GET["dni_f"])){
            $aux = 1; 
            $queryDoc .= " d.dni = '".$_GET["dni_f"]."' ";   
        }
        if(isset($_GET["aula_f"])){
            if($aux == 1){
                $queryDoc .= " AND  d.id_aula = '".$_GET["aula_f"]."' "; 
            }else{
                $queryDoc .= " d.id_aula = '".$_GET["aula_f"]."' "; 
            }
            $aux = 2;
        }
        if(isset($_GET["gen_f"])){
            if($aux == 2 || $aux == 1){
                $queryDoc .= " AND d.genero = '".$_GET["gen_f"]."' ";  
            }else{
                $queryDoc .= " d.genero = '".$_GET["gen_f"]."' ";  
            }
        }
    }

    ?>
    <div class="my-3 mb-4 row">
        <div class="col-12 col-md-4">
            <label for="doc_dni_f"> Filtrar DNI</label>
            <input type="number" class="form-control rounded-pill" id="doc_dni_f" value="<?php if(isset($_GET["dni_f"])){echo  $_GET["dni_f"];} ?>">
        </div>
        <div class="col-12 col-md-4">
            <label for="doc_aula_f"> Filtrar Aula</label>
            <select class="form-select rounded-pill" id="doc_aula_f">
                <option value="T" >Todos</option>
                <?php
                $sqlaulas = $conn->prepare("Select id, nombre from aula");
                $sqlaulas->execute();
                $sqlaulas->bind_result($id_aula_doc, $nombre_aula_doc);
                while($sqlaulas->fetch()){
                    ?>
                    <option value="<?=$id_aula_doc?>" <?php if(isset($_GET["aula_f"])){echo $id_aula_doc == $_GET["aula_f"] ? 'selected' : '';} ?> ><?=$nombre_aula_doc?></option>
                    <?php
                }
                $sqlaulas->close();
                ?>
            </select>
        </div>
        <div class="col-12 col-md-4">
            <label for="doc_gen_f"> Filtrar Genero</label>
            <select class="form-select rounded-pill" id="doc_gen_f">
                <option value="T" <?php if(isset($_GET["gen_f"])){echo 'T' == $_GET["gen_f"] ? 'selected' : '';} ?> >Todos</option>
                <option value="M" <?php if(isset($_GET["gen_f"])){echo 'M' == $_GET["gen_f"] ? 'selected' : '';} ?> >Hombre</option>
                <option value="F" <?php if(isset($_GET["gen_f"])){echo 'F' == $_GET["gen_f"] ? 'selected' : '';} ?> >Mujer</option>
            </select>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
        <button class="btn btn-warning rounded-pill px-5 mx-1" id="btnFiltrarDoc"><i class="fa-solid fa-magnifying-glass"></i> Filtrar Busqueda</button>
        <button class="btn btn-success rounded-pill px-5 mx-1" id="btnTodosDoc"><i class="fa-solid fa-border-all"></i> Mostrar Todos</button>
        <button class="btn btn-primary rounded-pill px-5 mx-1" id="btnActDoc"><i class="fa-solid fa-rotate"></i> Actualizar</button>
    </div>
    <div class="mt-4 px-2">
        <div class="table-responsive">
            <table class="table  table-hover" id="tablaDocente">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Foto</th>
                        <th scope="col">DNI</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Aula</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Nacimiento</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Genero</th>
                        <th scope="col">tipo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sqldoce_l= $conn->prepare($queryDoc);
                        $sqldoce_l->bind_result($id_doc_l, $cod_doc_l, $nom_doc_l, $ape_doc_l, $dir_doc_l, $nac_doc_l, $tel_doc_l, $corr_doc_l, $foto_doc_l, $aula_doc_l, $tipo_doc_l, $gen_doc_l, $pass_doc_l, $idaula_doc_l);
                        $sqldoce_l->execute();

                        while($sqldoce_l->fetch()){
                            ?>
                            <tr>
                                <th scope="row">
                                <?php 
                                if($foto_doc_l === null){
                                ?>
                                    <img src="/app_asistencia/src/images/userexample2.jpg" alt="Usuario"  class="imgredonda2" id="FTD-<?=$id_doc_l?>">
                                <?php
                                }else{
                                    ?>
                                    <img src="data:image/png;base64,<?php echo base64_encode($foto_doc_l) ?>" alt="Foto"  class="imgredonda2" id="FTD-<?=$id_doc_l?>">
                                <?php
                                }
                                ?>
                                </th>
                                <td><?=$cod_doc_l?></td>
                                <td><?=$nom_doc_l?></td>
                                <td><?=$ape_doc_l?></td>
                                <td><?=$aula_doc_l?></td>
                                <td><?=$dir_doc_l?></td>
                                <td><?=$nac_doc_l?></td>
                                <td><?=$tel_doc_l?></td>
                                <td><?=$corr_doc_l?></td>
                                <td><?=$gen_doc_l == 'M' ? 'Hombre' : 'Mujer'?></td>
                                <td><?=$tipo_doc_l == 'A' ? 'Administrador(a)' : 'Docente'?></td>
                                <td> 
                                    <?php
                                    if($id_doc_l != $_SESSION["id"]){
                                        ?>
                                          <button class="btn btn-warning rounded-pill my-1 d-block w-100" 
                                    onclick="editarDocLista(<?=$id_doc_l?>, '<?=$cod_doc_l?>', '<?=$nom_doc_l?>' , '<?=$ape_doc_l?>', '<?=$pass_doc_l?>', '<?=$dir_doc_l?>', '<?=$nac_doc_l?>', '<?=$tel_doc_l?>', '<?=$corr_doc_l?>', '<?=$gen_doc_l?>', <?=$idaula_doc_l?>, '<?=$tipo_doc_l?>')">
                                    <i class="fa-regular fa-pen-to-square"></i></button>
                                        <?php
                                    }
                                    ?>
                                  
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table> 
        </div>                               
    </div>
</div>
<div id="espacioModalEditar">
    <div class="modal fade" id="modalSettingDoc" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-uppercase fw-bold" >  
                    <i class="fa-solid fa-sliders"></i> Editar Docente 
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <form id="formEditarDocAdmin">
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-warning rounded-pill w-50 mx-1" data-bs-dismiss="modal" name="btnCancelar"><i class="fa-regular fa-circle-xmark mx-1"></i> Cancelar</button>
                            <button type="submit" class="btn btn-primary rounded-pill w-50 mx-1" name="btnActualizar"><i class="fa-solid fa-square-pen mx-1"></i> Actualizar Datos</button>
                            <button type="button" class="btn btn-danger rounded-pill w-50 mx-1"  name="btnBorrarDoc" id="btn_doc_delete"><i class="fa-regular fa-trash-can"></i> Borrar Docente</button>
                        </div>
                        <div class="row p-3 my-1">
                            <div class="col-lg-6 col-md-12  my-2">
                                <div class="mb-3">
                                    <label for="doc_dni_set" class="form-label"><i class="fa-solid fa-id-card"></i> Numero DNI (Codigo): </label>
                                    <input type="number" name="doc_dni_set" class="form-control fw-bold rounded-pill" id="doc_dni_set" required value="">
                                </div>
                                <div class="mb-3">
                                    <label for="doc_nom_set" class="form-label"><i class="fa-regular fa-file-lines"></i> Nombres:</label>
                                    <input type="text" name="doc_nom_set" class="form-control rounded-pill" id="doc_nom_set"  required value="" >
                                </div>
                                <div class="mb-3">
                                    <label for="doc_ape_set" class="form-label"><i class="fa-regular fa-file-lines"></i> Apellidos:</label>
                                    <input type="text" autocomplete="off"  name="doc_ape_set" class="form-control rounded-pill" id="doc_ape_set"  required value="">
                                </div>
                                <div class="mb-3">
                                    <label for="doc_pass_set" class="form-label"><i class="fa-solid fa-key"></i> Contraseña:</label>
                                    <input type="password" autocomplete="off" name="doc_pass_set" class="form-control rounded-pill" id="doc_pass_set"  required value="" >
                                </div>
                                <div class="mb-3">
                                    <label for="doc_dir_set" class="form-label"><i class="fa-solid fa-map-location-dot"></i> Dirección:</label>
                                    <input type="text" name="doc_dir_set" class="form-control rounded-pill" id="doc_dir_set"  required value="">
                                </div>
                                <div class="mb-3">
                                    <label for="doc_nac_set" class="form-label"><i class="fa-solid fa-calendar-days"></i> Fecha de nacimiento:</label>
                                    <input type="date"  name="doc_nac_set" class="form-control rounded-pill" id="doc_nac_set"  required value="" min="1950-01-01" max="">
                                </div>
                                <div class="mb-3">
                                    <label for="doc_tel_set" class="form-label"><i class="fa-solid fa-phone"></i> Telefono:</label>
                                    <input type="number" name="doc_tel_set" class="form-control rounded-pill" id="doc_tel_set"  required value="" >
                                </div>
                                <div class="mb-3">
                                    <label for="doc_corr_set" class="form-label"><i class="fa-regular fa-envelope"></i> Correo Electronico:</label>
                                    <input type="email" name="doc_corr_set" class="form-control rounded-pill" id="doc_corr_set"  required value="">
                                </div>
                                <div class="mb-3">
                                    <label for="doc_gen_set" class="form-label"><i class="fa-solid fa-user"></i> Genero:</label>
                                    <select class="form-select rounded-pill" name="doc_gen_set" id="doc_gen_set" >
                                        <option value="M" > Hombre</option>
                                        <option value="F"> Mujer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 my-2">   
                                <div>
                                    <div class=" my-3 d-flex d-flex justify-content-center" id="doc_img_set">
                                    <img src='' alt="Foto"  class="border border-4" width="200px" id="img_foto_doc_edit">
                                    </div>
                                
                                    <div class="p-1">
                                        <label for="doc_file_set" class="form-label px-1">Elegir una foto (12mb max)</label>
                                        <input  name="doc_file_set" class="form-control form-control-sm rounded-pill" id="doc_file_set" type="file" accept=".png" >
                                    </div>

                                    <div class="d-flex">
                                        <button type="button"  id="btn_doc_fotomod" class="btn btn-outline-primary rounded-pill my-3 mx-1 w-50" ><i class="fa-regular fa-pen-to-square"></i> Actualizar foto</button>
                                        <button type="button"  id="btn_doc_fotodel" class="btn btn-outline-danger rounded-pill my-3 mx-1 w-50"><i class="fa-solid fa-trash-can"></i> Eliminar foto</button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="doc_aula_set" class="form-label"><i class="fa-brands fa-ethereum "></i> Aula Asignada:</label>
                                    <select class="form-select rounded-pill" name="doc_aula_set" id="doc_aula_set" required >             
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

                                <div class="mb-3">
                                    <label for="doc_tipo_set" class="form-label"><i class="fa-solid fa-users-viewfinder"></i> Tipo de usuario:</label>
                                    <select class="form-select rounded-pill" name="doc_tipo_set" id="doc_tipo_set" required >
                                        <option value="A"> Administrador</option>
                                        <option value="D"> Docente</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/app_asistencia/src/js/docentes.js"></script>
<?php require_once("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/views/admin_footer.php"); ?>