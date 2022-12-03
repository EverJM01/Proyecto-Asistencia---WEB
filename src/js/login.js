const formulario = document.getElementById("formularioLogin");
let modal = null;

const modalVal1 = 
`<div class="modal fade"  tabindex="-1"  aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-body">
    <h1 style="text-align:center"><i class="fa-solid fa-lightbulb"></i></h1>
     <h2 style="text-align:center" class="fw-bold"> Porfavor, colocar datos validos</h2>
     <p>- Numero DNI (8 caracteres) <br>- Contraseña (6 caracteres) </p>
    </div>
    <div class="my-3 d-flex justify-content-center">
      <button type="button" class="btn btn-danger w-50 mx-1 rounded-pill" data-bs-dismiss="modal">Regresar</button>
    </div>
  </div>
</div>
</div>`;

const modalval2 = 
` <div class="modal fade" tabindex="-1"  aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-body">
    <h1 style="text-align:center"><i class="fa-solid fa-circle-exclamation"></i></h1>
     <h2 style="text-align:center" class="fw-bold">Campos Vacios</h2>
    </div>
    <div class="my-3 d-flex justify-content-center">
      <button type="button" class="btn btn-danger w-50 mx-1 rounded-pill" data-bs-dismiss="modal">Regresar</button>
    </div>
  </div>
</div>
</div>
`;

const modalval3 = 
` <div class="modal fade" tabindex="-1" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-body">
    <h1 style="text-align:center"><i class="fa-solid fa-triangle-exclamation"></i></h1>
     <h2 style="text-align:center" class="fw-bold"> Usuario no encontrado</h2>
    </div>
    <div class="my-3 d-flex justify-content-center">
      <button type="button" class="btn btn-danger w-50 mx-1 rounded-pill" data-bs-dismiss="modal">Regresar</button>
    </div>
  </div>
</div>
</div>
`;

const createModal = (modalTipo) => {
      if(modal !== null ){
            modal.remove();
      }
      modal = document.createElement('div');
      modal.innerHTML = modalTipo;
      document.body.append(modal);
}

const mostrarModal = (modalTipo) => {
      createModal(modalTipo);
      const mod = new bootstrap.Modal(modal.querySelector('.modal'));
      mod.show();
}

const validacion = async (e) => {
      e.preventDefault();
      const datoslogin = new FormData(formulario)
      const dni = datoslogin.get('userdni').toString();
      const pass = datoslogin.get('userpass').toString();

      if(dni == "" || pass == ""){
            mostrarModal(modalval2);   
            return;
      }
      if(dni.length != 8 || pass.length != 6){
            mostrarModal(modalVal1); 
            return;
      }
    
      await fetch("/app_asistencia/controllers/validarUsuario.php", {
            method: 'POST',
            body: datoslogin
      })
      .then( res => res.json())
      .then( data => {
            if(data === 'falseUser'){
                  mostrarModal(modalval3); 
                  return;
            }
          window.location.href = "/app_asistencia/controllers/accesoController.php?iduser="+data.id+"&coduser="+data.codigo+"&passuser="+data.pass+"";
      })
}

formulario.addEventListener("submit", validacion);
