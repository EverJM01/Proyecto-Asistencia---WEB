<?php 
session_start();
if(empty($_SESSION["id"])){
      header("Location: /app_asistencia/index.php");
}else{
    include("".$_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");  

    $iduser = $_SESSION["id"];
    
    $sqluser = $conn->prepare("SELECT u.codigo, u.pass, u.tipo, d.nombre, d.apellido, d.direccion, d.fechanac, d.telefono, d.correo, d.dni, d.genero, d.foto, d.id_aula FROM usuario u INNER JOIN docente d ON d.id = u.id WHERE u.id = ?");
    
    $sqluser->bind_param("i", $iduser);
    $sqluser->execute();
    $sqluser->bind_result($codigouser, $passuser, $tipouser, $nombreuser, $apellidouser, $direccionuser, $fechanacuser, $telefonouser, $correouser, $dniuser, $generouser, $fotouser, $idaulauser);
    $sqluser->fetch();
    $sqluser->close(); 

    $sqluser2 = $conn->prepare("SELECT nombre, descripcion FROM aula WHERE id = ?");
    
    $sqluser2->bind_param("i", $idaulauser);
    $sqluser2->execute();
    $sqluser2->bind_result($nombre_aulauser, $descrip_aulauser);
    $sqluser2->fetch();
    $sqluser2->close();


}


?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="shortcut icon" href="/app_asistencia//src/images/icon.png" type="image/x-icon" >
        <link href="/app_asistencia/src/css/admin.css" rel="stylesheet" />
        <title>Asistencia WEB</title>
    </head>
    <body class="sb-nav-fixed ">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary bg-gradient">
            <p class="navbar-brand ps-3" ><?php 
                if($tipouser === 'A'){
                    echo "<i class='fa-solid fa-crown'></i> Administración";
                }
                if($tipouser === 'D'){
                    echo " <i class='fa-solid fa-chalkboard-user'></i> Docente";
                }
            ?></p>
            <button class="btn order-1 order-lg-0 me-4 me-lg-0 lead fw-bold mt-1" id="sidebarToggle" ><i class="fas fa-bars me-3 mt-1"></i><h5 class="float-end d-none d-lg-block"><?=" ".$TITULO_PAGINA?></h5></button>
            
            <div class="d-none d-md-inline-block ms-auto me-md-1 my-2 my-md-0">
               
                <p class=" text-light mt-3 lead fw-bold"><?php echo $nombreuser." ".$apellidouser ?></p>
            </div>
            <div class="mx-1 d-none d-sm-block ">
                <?php 
                    if($fotouser === null){
                ?>
                    <img src="/app_asistencia/src/images/userexample2.jpg" alt="Usuario"  class="imgredonda ">
                <?php
                }else{
                    ?>
                    <img src="data:image/png;base64,<?php echo base64_encode($fotouser) ?>" alt="Foto"  class="imgredonda">
                <?php
                }
                ?>
                
            </div>
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 ">
                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle lead ms-1" id="navbarDropdown"  role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-gear"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 menuuserset" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item rounded-pill m-1 my-1 fw-bold" role="button" data-bs-toggle="modal" data-bs-target="#modalSettingUser"><i class="fa-solid fa-user"></i> Mi perfil</a></li>
                        <li><a class="dropdown-item rounded-pill m-1 my-1 fw-bold" role="button" data-bs-toggle="modal" data-bs-target="#modalAsisTemp"><i class="fa-solid fa-pen-clip"></i> Tomar Asistencia</a></li>
                        <li><a class="dropdown-item rounded-pill m-1 my-1 fw-bold text-danger" role="button" href="/app_asistencia/controllers/cerrarsesion.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark bg-primary " id="sidenavAccordion">
                    <div class="sb-sidenav-menu parascroll" >
                        <div class="nav fw-normal">
                            <div class="sb-sidenav-menu-heading text-light">SECCIONES A ELEGIR</div>
                            <a class="nav-link rounded-pill mx-1 mihoverbtn <?=$VISTA_TITULO == 0 ? 'active' : '' ?>" href="user_inicio.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-house-user"></i></div>Inicio
                            </a>
                            <a class="nav-link mihoverbtn rounded-pill mx-1 mihoverbtn <?=$VISTA_TITULO == 1 ? 'active' : '' ?>" href="user_estudiantes.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-graduation-cap"></i></div>Estudiantes
                            </a>
                            <a class="nav-link rounded-pill mx-1 mihoverbtn <?=$VISTA_TITULO == 2 ? 'active' : '' ?>" href="user_asistencias_general.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-receipt"></i></div>Asistencias
                            </a>
                    
                            <a class="nav-link rounded-pill mx-1 mihoverbtn <?=$VISTA_TITULO == 3 ? 'active' : '' ?>" href="user_codigoqr.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-qrcode"></i></div>Generar Codigo QR
                            </a>
                            <a class="nav-link rounded-pill mx-1 mihoverbtn <?=$VISTA_TITULO == 4 ? 'active' : '' ?>" href="user_reportes.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-receipt"></i></div>Reportes
                            </a>
                            <?php
                                if($tipouser === 'A'){
                            ?>
                                <a class="nav-link rounded-pill mx-1 mihoverbtn <?=$VISTA_TITULO == 5 ? 'active' : '' ?>" href="user_docentes.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-school"></i></div>Docentes
                                </a>
                           
                                <a class="nav-link collapsed rounded-pill mx-1 mihoverbtn <?=$VISTA_TITULO == 6 ? 'active' : '' ?>" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#colegioCollapse" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-mug-saucer"></i></div>Adicional
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="colegioCollapse" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link <?=$VISTA_SUBTITULO == 6.1 ? 'active' : '' ?>" href="user_adicional_horario.php">Horario</a>
                                        <a class="nav-link <?=$VISTA_SUBTITULO == 6.2 ? 'active' : '' ?>" href="user_adicional_aulas.php">Aulas</a>
                                        <a class="nav-link <?=$VISTA_SUBTITULO == 6.3 ? 'active' : '' ?>" href="user_adicional_apoderados.php">Apoderados</a>
                                    </nav>
                                </div>
                            <?php 
                                }
                            ?>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer bg-primary  text-light fw-bold">
                        <div class="small">Numero DNI:</div><i class="fa-solid fa-id-card"></i>
                        <?php echo $codigouser ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
            <main>


            <div class="modal fade" id="modalAsisTemp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered  modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <img src="/app_asistencia/src/images/asistencia.png" alt="asistencia" width="50px" class="mx-2">
            <h3 class="modal-title text-uppercase fw-bold" id="staticBackdropLabel">tomar Asistencia</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body ">
            <div class="row p-3">
              <div class="col-lg-6 col-md-12 mb-2 ">
                <p class="lead">Por favor colocar el número de D.N.I. para registrar la asistencia</p>
                <div class="d-none  d-lg-block">
                    <?php
                    $sql = $conn->query("select * from horario where id=1");
                    $hora_1a = null;
                    $hora_2a = null;
                    $hora_3a = null;
                    
                    if($datos = $sql->fetch_object()){
                      $hora_1a = date_format(date_create($datos->hora_inicio), "H:i");
                      $hora_2a = date_format(date_create($datos->hora_tardanza), "H:i");
                      $hora_3a = date_format(date_create($datos->hora_final), "H:i");
                    }
                   
                    ?>
                <p class="lead  bg-primary text-light my-0  py-3"><i class="fa-solid fa-face-grin-stars mx-3 my-2"></i> Puntual inicia <?=$hora_1a ?></p>
                <p class="lead  bg-warning text-dark my-0  py-3"><i class="fa-solid fa-hourglass-half mx-3 my-2 "></i>  Tardanza desde <?=$hora_2a ?></p>
                <p class="lead  bg-danger text-light mb-0  py-3"><i class="fa-solid fa-face-sad-tear mx-3 my-2"></i>  Falta desde <?=$hora_3a ?></p>
                </div>
                
              </div>
              <div class="col-lg-6 col-md-12">
                <form class="form form-control" id="formularioasistencia">
                  <div class="my-2">
                    <label for="dniuserasis" class="form-label lead">Numero de DNI:</label>
                    <input type="number" class="form-control lead rounded-pill" id="dniuserasis" name="dniuserasis">
                  </div>
                  <button type="submit" class="btn btn-success  w-100 my-2 rounded-pill"><p class="lead p-0 m-0">Presentar</p></button>
                </form>
                
                <div id="alertass2" class="mt-1">
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>