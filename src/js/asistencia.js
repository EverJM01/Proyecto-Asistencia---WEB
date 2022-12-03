const formularioasis = document.getElementById("formularioasistencia");
let alerta = document.getElementById("alertass2");
let alertab = null;
 
const alert1 = 
`<div class="alert alert-secondary alert-dismissible fade show lead fw-bold rounded-pill" role="alert" id="alerta">
<i class="fa-regular fa-circle-question"></i> Colocar DNI
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>`;

const alert2 = 
`<div class="alert alert-secondary alert-dismissible fade show lead fw-bold" role="alert" id="alerta">
<i class="fa-regular fa-face-tired"></i> DNI no admitido
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>`;

const alert3 = 
`<div class="alert alert-secondary alert-dismissible fade show lead fw-bold" role="alert" id="alerta">
<i class="fa-solid fa-triangle-exclamation"></i> DNI no encontrado en la base de datos
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>`;

const alertp1 = 
`<div class="alert alert-primary alert-dismissible fade show lead fw-bold" role="alert" id="alerta">
<i class="fa-solid fa-face-laugh-beam"></i> GRACIAS POR SU PUNTUALIDAD, ASISTENCIA TOMADA
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>`;

const alertp2 = 
`<div class="alert alert-warning alert-dismissible fade show lead fw-bold" role="alert" id="alerta">
<i class="fa-solid fa-face-surprise"></i> ASISTENCIA TOMADA, PERO CON TARDANZA
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>`;

const alertp3 = 
`<div class="alert alert-danger alert-dismissible fade show lead fw-bold" role="alert" id="alerta">
<i class="fa-regular fa-face-sad-tear"></i> SE PASO EL TIEMPO, LO SENTIMOS
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>`;

const alertp4 = 
`<div class="alert alert-secondary alert-dismissible fade show lead fw-bold" role="alert" id="alerta">
Tu asistencia ya a sido tomada
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>`;

const alertp5 = 
`<div class="alert alert-secondary alert-dismissible fade show lead fw-bold" role="alert" id="alerta">
Aun no se apertura la asistencia
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>`;


const createAlert = (alertipo) => {
      if(alertab !== null ){
            alertab.remove();
      }
      alertab = document.createElement('div');
      alertab.innerHTML = alertipo;
      alerta.appendChild(alertab);
} 

const validacionasis = async (e) => {
      e.preventDefault();
      const datosasis = new FormData(formularioasis)
      const dni = datosasis.get('dniuserasis').toString();
      if(dni == ""){
            createAlert(alert1);
            return;
      }
      if(dni.length != 8){
            createAlert(alert2);
            return;
      }
      
      await fetch("/app_asistencia/controllers/validarAsis.php", {
            method: 'POST',
            body: datosasis
      })
      .then( res => res.json())
      .then( data => {
            if(data === 'noexisteUser'){
                  createAlert(alert3);
                  return;
            }
            if(data === 'puntualUser'){
                  createAlert(alertp1);
                  return;
            }
            if(data === 'tardeUser'){
                  createAlert(alertp2);
                  return;
            }
            if(data === 'faltaUser'){
                  createAlert(alertp3);
                  return;
            }
            if(data === 'existeAsisUser'){
                  createAlert(alertp4);
                  return;
            }
            if(data === 'todaviaUser'){
                  createAlert(alertp5);
                  return;
            }
      })    
}

formularioasis.addEventListener("submit", validacionasis);
