document.getElementById("btnfiltraraula").addEventListener("click", ()=>{
window.location.href = "/app_asistencia/views/user_adicional_apoderados.php?idaula_p="
+document.getElementById("listaAula").value });

const txtdniapo = document.getElementById("txtdni");  
const espacioApo = document.getElementById("listar_apoderados");
let apoderadotener = false;
let nombre_apo = null;
let telefono_apo = null;
let id_apo = null;
let id_est = null;

const generarApo = async(e) =>{
        e.preventDefault();
        if(txtdniapo.value.length !== 8){
            alert("Ingresar el numero DNI valido");
            return;
        } 
        
        await fetch("/app_asistencia/controllers/listarApoderados.php?dni="+txtdniapo.value)
        .then( res => res.json())
        .then( data => {
                if(data[1] === 'no listo'){
                        apoderadotener = false;
                        id_est = data[0];
                        console.log(data);
                }else{
                        id_apo = data[0]
                        nombre_apo = data[1];
                        telefono_apo = data[2];
                        id_est = data[3];
                        console.log(data);
                        apoderadotener = true;
                } 
                
                crearListarApo(apoderadotener);
        })    
}


document.getElementById("btnapoderados2").addEventListener("click", generarApo);
let modalapo = null;
let listarApo  =  null;

function validarCampos(){
        const nomapo = document.getElementById("nom_apo").value;
        const telapo = document.getElementById("tel_apo").value;
        const dniest = txtdniapo.value;
        if(nomapo.length > 100){
                alert("nombre no valido");
                return false;
        }
        if(telapo.length != 9){
                alert("telefono no valido");
                return false;
        }
        if(dniest.length != 8){
                alert("DNI no valido");
                return false;
        }
        return true;

}

async function editarApo(){
        const nomapo = document.getElementById("nom_apo").value;
        const telapo = document.getElementById("tel_apo").value;
        const dniest = txtdniapo.value;
        if(validarCampos()){
                await fetch("/app_asistencia/controllers/actualizarApo.php?dni="+dniest+"&nombre="+nomapo+"&tel="+telapo)
                        .then( res => res.json())
                        .then( data => {
                                if(data==='listo'){
                                alert("Apoderado Editado");    
                                }
                        }) 
        }
        
           
}

async function crearApo(){
        const nomapo = document.getElementById("nom_apo").value;
        const telapo = document.getElementById("tel_apo").value;
     
        if(validarCampos()){
                await fetch("/app_asistencia/controllers/crearApo.php?idest="+id_est+"&nombre="+nomapo+"&tel="+telapo)
                        .then( res => res.json())
                        .then( data => {
                                if(data==='listo'){
                                alert("Apoderado creado");    
                                }
                        }) 
        }
}

function crearListarApo(tenerapo){
        if(listarApo != null){
                listarApo.remove();
        }
        listarApo = document.createElement('div');
        listarApo.innerHTML = tenerapo == true ? `<hr>
        <h4>Nombre:</h4>
        <input type="text" id="nom_apo" class="form-control" value="`+nombre_apo+`" required>
        <hr>
        <h4>Telefono: </h4>

        <input type="number" id="tel_apo" class="form-control" value="`+telefono_apo+`" required>
        <hr>
        <button type="button" class="btn btn-secondary" id="editarApo" onclick="editarApo()" >Editar</button>`: 
        `<h4>No tiene Apoderado</h4>
        <hr>
        <p>Nombre:</p>
        <input type="text" id="nom_apo" class="form-control" required>
        <hr>
        <p>Telefono:</p>
        <input type="number" id="tel_apo" class="form-control" required>
        <hr>
        <button type="button" class="btn btn-secondary" id="crearApo" onclick="crearApo()">Crear nuevo apoderado</button>`;
        espacioApo.append(listarApo);
}

function mostrarListarApo(){

}

const createModalqr = (modalTipo) => {
        if(modalapo !== null ){
            modalapo.remove();
        }
        modalapo = document.createElement('div');
        modalapo.innerHTML = modalTipo;
        document.body.append(modalapo);
}
const mostrarModalqr = (modalTipo) => {
        createModalqr(modalTipo);
        const mod = new bootstrap.Modal(modalapo.querySelector('.modal'));
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
        txtdniapo.value=dni;
}