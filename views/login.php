<?php 
include($_SERVER['DOCUMENT_ROOT']."/app_asistencia/database/db.php");
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de asistencia</title>
    <link href="/app_asistencia/src/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="/app_asistencia/src/images/icon.png" type="image/x-icon" >
    <link rel="stylesheet" href="/app_asistencia/src/css/login.css">
  </head>
  <body>
    <section>
      <div class="row g-0">
        <div class="col-md-5 d-flex  align-items-end min-vh-100 ">
          <div class="px-lg-5 py-lg-3 p-3 w-100 align-self-center">
            <div class="user-login mb-3">
              <img src="/app_asistencia/src/images/user02.jpeg" class="img-fluid " width="200px"> 
            </div>
            <h1 class="fw-bold mb-1">Bienvenido(a)</h1>
            <h4 class=" mb-3">Sistema de asistencia de la I.E. Capullitos de Amor N°1542</h4>

            <form class="form mb-5 p-2"  id="formularioLogin">
              <div class="mb-4">
                <label for="txtNumeroDni" class="form-label fw-bold"><i class="fa-solid fa-user"></i> Numero DNI:</label>
                <input type="number" class="form-control rounded-pill" id="txtNumeroDni" placeholder="Ingresa tu numero DNI" name="userdni">
              </div>
              <div class="mb-4">
                <label for="txtPassword" class="form-label fw-bold"><i class="fa-solid fa-key"></i> Contraseña:</label>
                <input type="password" class="form-control rounded-pill" id="txtPassword" placeholder="Ingresa tu contraseña" name="userpass">
              </div>
              <div class="d-flex">
                <button type="submit"  class="btn btn-primary rounded-pill mx-1 w-50 py-2"  name="btnacceder" id="btnacceder" ><i class="fa-solid fa-arrow-right-to-bracket"></i> Iniciar Sesion</button>
                <button type="button" class="btn btn-success rounded-pill mx-1 w-50 py-2"  data-bs-toggle="modal" data-bs-target="#staticBackdrop" ><i class="fa-solid fa-circle-info"></i> Adicional</button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-7 d-none d-md-block min-vh-100 mb-0">
          <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active bg-c1 min-vh-100">
              </div>
              <div class="carousel-item bg-c2 min-vh-100">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Siguiente</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Atras</span>
            </button>
          </div>
        </div>
      </div>
   </section>
   
   <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered  modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title text-uppercase fw-bold" id="staticBackdropLabel">Informacion Adicional</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body ">
              <h1>Mision</h1>
              <p style="text-align: justify">Ofrecer un ambiente educativo de vanguardia y en constante desarrollo para la formación integral de alumnos en edad Preescolar, cuya base sean los valores, tomando en cuenta sus características individuales, así como el amor a sí mismos, hacia los demás y hacia el medio ambiente.</p>
              <h1>Vision</h1>
              <p style="text-align: justify">Ser una organización educativa que brinde a los niños una formación espiritual e intelectual que contribuya en un futuro a la transformación de una sociedad de paz.Ofrecer las herramientas necesarias para la vida dentro de un ambiente preparado que proporcione los medios para conquistar independencia, libertad y autodisciplina. De esta manera estaremos contribuyendo a la formación del carácter y la personalidad del niño para que pueda triunfar en esta sociedad de cambios continuos.</p>
              <a class="btn btn-primary rounded-pill" href="https://www.facebook.com/profile.php?id=100057180950542" target="_blank"><i class="fa-brands fa-facebook"></i> Visitar pagina </a>
            </div>
        </div>
      </div>
    </div>
    <script src="/app_asistencia/src/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="/app_asistencia/src/js/bootstrap/popper.min.js"></script>
    <script src="/app_asistencia/src/js/bootstrap/bootstrap.min.js"></script>

    <script src="/app_asistencia/src/js/login.js"></script>
    
  </body>
</html>