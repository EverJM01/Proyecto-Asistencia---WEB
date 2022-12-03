const codigoimgqr = document.getElementById("codigoqr_img");  
const btngenerar = document.getElementById("btngenerarqr");  
const txtdni = document.getElementById("txtdniqr");  

const btnfiltraraula = document.getElementById("btnfiltraraula");  
const listaraula= document.getElementById("listaAula");  

let qrcode = null;

function generarqr(e){
      e.preventDefault();
      if(txtdni.value.length !== 8){
            alert("Ingresar el numero DNI valido");
            return;
      }

      if(qrcode !== null){
            qrcode.clear();
            qrcode.makeCode(txtdni.value);
            return;
      }

      qrcode = new QRCode(codigoimgqr, {
            text: txtdni.value,
            width: 190,
            height: 190,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H

      }); 
}

btngenerar.addEventListener("click", generarqr);



//--------------------------------------------------------


let modalqr = null;
const createModalqr = (modalTipo) => {
      if(modalqr !== null ){
            modalqr.remove();
      }
      modalqr = document.createElement('div');
      modalqr.innerHTML = modalTipo;
      document.body.append(modalqr);
}

const mostrarModalqr = (modalTipo) => {
      createModalqr(modalTipo);
      const mod = new bootstrap.Modal(modalqr.querySelector('.modal'));
      mod.show();
}


function mostrarDatosEst(dni){
      const imgfoto = document.getElementById("FT-"+dni);
      const modalDatosEst = 
      `<div class="modal fade"  tabindex="-1"  aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-body">
      <h1 style="text-align:center">DNI: `+dni+`</h1>
      <div class="d-flex justify-content-center">
      <img src='`+imgfoto.src+`'>
      </div>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Regresar</button>
      </div>
      </div>
      </div>
      </div>`;

      mostrarModalqr(modalDatosEst);

}

function mostarDniQr(dni){
      txtdni.value=dni;
}

btnfiltraraula.addEventListener("click", ()=>{
      window.location.href = "/app_asistencia/views/user_codigoqr.php?idaula_p="+listaraula.value;
});
