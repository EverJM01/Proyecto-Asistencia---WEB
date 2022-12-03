<?php 
$VISTA_TITULO = 6;
$VISTA_SUBTITULO = 6.2;
$TITULO_PAGINA = 'AULAS';
require_once("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/views/admin_header.php");

?>


<div class="container-fluid px-4">
<div class="mt-2">
        <h1><i class="fa-solid fa-graduation-cap"></i> Configurar Aulas</h1>
        <hr>
        <div class="row">
            
            <div class="col-12 col-lg-8 divscrollxd ">
                <div class="row">
                    <h3>Crear nueva aula</h3>
                    <div class="col-6 my-4">
                        Nombre:
                        <input type="text" class="form-control" id="nom_aulax">
                        <a class="btn btn-primary rounded-pill w-100 my-1" id="btnactualizarx" href="/app_asistencia/views/user_adicional_aulas.php"><i class="fa-solid fa-arrows-rotate"></i> Actualizar</a>
                    </div> 
                    <div class="col-6 my-4">
                        Descripción:
                        <input type="text" class="form-control" id="des_aulax">
                        <button class="btn btn-secondary rounded-pill w-100 my-1" id="btnlimpiarx"><i class="fa-solid fa-chalkboard"></i> Limpiar</button>
                        <button class="btn btn-success rounded-pill w-100 my-1" id="btncrearaula"><i class="fa-regular fa-thumbs-up"></i> Registrar</button>
                    </div> 
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col"></th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlaula = $conn->prepare("SELECT * from aula ;");
                        $sqlaula->execute();
                        $sqlaula->bind_result($id_aula, $nom_aula, $des_aula);
                     
                        $numfila = 1;
                        while($sqlaula->fetch()){
                            ?>
                           
                            <tr>
                                <form action="/app_asistencia/controllers/editarAula.php" method="GET">
                                <th class="px-0" scope="row"><?=$numfila?><input type="text" class="bordtxt" name="id_aulaxs" value="<?=$id_aula?>" required hidden></th>
                                <td class="px-0"><input type="text" class="form form-control rounded-pill" name="nom_a" value="<?=$nom_aula?>" required></td>
                                <td class="px-0"><input type="text" class="form form-control rounded-pill" name="des_a" value="<?=$des_aula?>" required></td>
                                <td class="px-0">
                                    <div class="d-flex">
                                        <a role="button" class="btn btn-danger mx-1"  href="/app_asistencia/controllers/eliminarAula.php?id=<?=$id_aula?>"><i class="fa-solid fa-trash"></i></a>
                                        <button type="submit" class="btn btn-success" name="btnidaula" value="<?=$id_aula?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                        </form>
                                        <button class="btn btn-warning px-2 ms-1"  onclick="mostrarDocente(<?=$id_aula?>)"><i class="fa-solid fa-person-chalkboard"></i></button>
                                    </div>
                                    
                                </td>
                                
                            </tr>
                            <?php
                            $numfila++;
                            }
                        $sqlaula->close(); 
                        ?>
                        
                    </tbody>
                </table>
            </div>
            <div class="col-12 col-lg-4">
                <h3>Docentes registrados</h3>
                <div id="espacio_doc">

                </div>
            </div>
        </div>
    </div>
</div>
<script src="/app_asistencia/src/js/aulas.js"></script>
<?php require_once("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/views/admin_footer.php"); ?>