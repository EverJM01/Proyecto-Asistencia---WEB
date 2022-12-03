const btnFiltrarDoc = document.getElementById("btnFiltrarDoc");
const btnTodosDoc = document.getElementById("btnTodosDoc");
const btnActDoc = document.getElementById("btnActDoc");
const btnlimpiardoc = document.getElementById("btnlimpiarDoc");

const aula_f = document.getElementById("doc_aula_f");
const gen_f = document.getElementById("doc_gen_f");
const dni_f = document.getElementById("doc_dni_f");

const espacionModEd = document.getElementById("espacioModalEditar");
const formCrearDoc = document.getElementById("formCrearDoc");

let direccion = "/app_asistencia/views/user_docentes.php";

btnActDoc.addEventListener("click", ()=>{
    location.reload();
});

btnTodosDoc.addEventListener("click", ()=>{
    window.location.href = direccion;
});

btnFiltrarDoc.addEventListener("click", ()=>{
    if(dni_f.value.length == 8 || gen_f.value != 'T' || aula_f.value != 'T'){
        direccion += "?";
        let aux = 0;
        if(dni_f.value.length == 8){
            direccion += "dni_f="+dni_f.value;
            aux++;
        
        }
        if(gen_f.value != 'T'){ 
            if(aux == 1){
                direccion += "&";
            }
            direccion += "gen_f="+gen_f.value;
            aux++;
        }
        if(aula_f.value != 'T'){
            if(aux == 2 || aux == 1){
                direccion += "&";
            }
            direccion += "aula_f="+aula_f.value;
        }
    }
    window.location.href = direccion;
});

formCrearDoc.addEventListener("submit", async (e)=>{
    e.preventDefault();
    const datosdoc = new FormData(formCrearDoc);
    if(datosdoc.get("doc_nom").length > 100 || datosdoc.get("doc_nom").length < 2){
        alert("Nombre Invalido");
        return;
    }

    if(datosdoc.get("doc_ape").length > 100 || datosdoc.get("doc_ape").length < 2){
        alert("Apellido Invalido");
        return;
    }

    if(datosdoc.get("doc_dni").length != 8 ){
        alert("DNI Invalido");
        return;
    }

    if(datosdoc.get("doc_tel").length != 9 ){
        alert("Telefono Invalido");
        return;
    }
    let admitir = 0;
   
        await fetch("/app_asistencia/controllers/validarDni.php?dni_muestra="+datosdoc.get("doc_dni"))
        .then( res => res.json())
        .then( data => {
            if(data === 'truedni'){
                alert("DNI ya existe en la base de datos"); 
                admitir = 1;
                return;
            } 
            admitir = 0;
        })
    
    if(admitir === 0){
        await fetch("/app_asistencia/controllers/registrarDocente.php", {
                method: 'POST',
                body: datosdoc
            })
            .then( res => res.json())
            .then( data => {
                    if(data === 'listo'){
                        alert("Docente registrado");
                        location.reload();
                    }
            })
    }else{
        return;
    }
    
});

btnlimpiardoc.addEventListener("click", (e)=>{
    e.preventDefault();
    formCrearDoc.reset();
});


const modalEditDoc = document.getElementById("espacioModalEditar");

const img_doc_show = document.getElementById("img_foto_doc_edit");

const doc_tipo_u = document.getElementById("doc_tipo_set");
const doc_aula_u = document.getElementById("doc_aula_set");
const doc_dni_u = document.getElementById("doc_dni_set");
const doc_nom_u = document.getElementById("doc_nom_set");
const doc_ape_u = document.getElementById("doc_ape_set");
const doc_pass_u = document.getElementById("doc_pass_set");
const doc_dir_u = document.getElementById("doc_dir_set");
const doc_nac_u = document.getElementById("doc_nac_set");
const doc_tel_u = document.getElementById("doc_tel_set");
const doc_corr_u = document.getElementById("doc_corr_set");
const doc_gen_u = document.getElementById("doc_gen_set");

const doc_fileimg = document.getElementById("doc_file_set");
const btn_docimg_up = document.getElementById("btn_doc_fotomod");
const btn_docimg_del = document.getElementById("btn_doc_fotodel");

const form_doc_edit = document.getElementById("formEditarDocAdmin");
const btn_doc_delete = document.getElementById("btn_doc_delete");

let DNI_DOC_EDIT = '';

const mostrarModalEdit = () => {
    const mod = new bootstrap.Modal(modalEditDoc.querySelector('.modal'));
    mod.show();
}

function editarDocLista(iddoce, coddoce, nomdoce, apedoce, passcode, dirdoce, nacdoce, teldoce, corrdoce, gendoce, auladoce, tipodoce){
    img_doc_show.src = document.getElementById("FTD-"+iddoce).src;

    doc_tipo_u.value = tipodoce;
    doc_aula_u.value = auladoce;
    doc_dni_u.value = coddoce;
    doc_nom_u.value = nomdoce;
    doc_ape_u.value = apedoce;
    doc_pass_u.value = passcode;
    doc_dir_u.value = dirdoce;
    doc_nac_u.value = nacdoce;
    doc_tel_u.value = teldoce;
    doc_corr_u.value = corrdoce;
    doc_gen_u.value = gendoce;

    btn_doc_delete.onclick = ()=>{eliminarDocenteAdmin(iddoce)};
    DNI_DOC_EDIT = coddoce;
    mostrarModalEdit();
}

form_doc_edit.addEventListener("submit", async (e)=>{
    e.preventDefault();
    const datosDoc = new FormData(form_doc_edit);
    let confirmacion = confirm("¿Desea actualizar los datos? ");

    if(!confirmacion){
        return;
    }
    if(doc_dni_u.value.length != 8){
        alert("DNI no admitido");
        return;
    }
    if(doc_pass_u.value.length > 6){
        alert("Contraseña no admitido\n(6 caracteres maximo)");
        return;
    }
    if(doc_tel_u.value.length != 9){
        alert("Telefono no admitido");
        return;
    }
    let admitir = 0;
    if(doc_dni_u.value !== DNI_DOC_EDIT){
        await fetch("/app_asistencia/controllers/validarDni.php?dni_muestra="+doc_dni_u.value.toString())
        .then( res => res.json())
        .then( data => {
            if(data === 'truedni'){
                alert("DNI ya existe en la base de datos"); 
                admitir = 1;
                return;
            } 
            admitir = 0;
        })
    }
    if(admitir !== 1){
        await fetch("/app_asistencia/controllers/actualizarDocente.php?dnidoc="+DNI_DOC_EDIT,{
            method: 'POST',
            body: datosDoc
        })
        .then( res => res.json())
        .then( data => {
                if(data==='listo'){
                alert("Docente Actualizado");   
                location.reload(); 
                }
        })
    }
    
});

async function eliminarDocenteAdmin(idDoc){
    let confirmacion = confirm("¿desea eliminar al Docente?");
    if(!confirmacion){
        return;
    }
    await fetch("/app_asistencia/controllers/eliminarDocente.php?iddoce="+idDoc)
    .then( res => res.json())
    .then( data => {
            if(data==='listo'){
            alert("Docente Eliminado");   
            location.reload(); 
            }
    }) 
}



const btnfotoup_d = document.getElementById("btn_doc_fotomod");
const btnfotodel_d = document.getElementById("btn_doc_fotodel");
const filefoto_d = document.getElementById("doc_file_set"); 

const actualizarfoto_d = async () => {
      let datosUser = new FormData();
      datosUser.append("archivofoto", filefoto_d.files[0])
      const fileName = filefoto_d.value; 
      const idxDot = fileName.lastIndexOf(".") + 1; 
      const extFile = fileName.substr(idxDot, fileName.length).toLowerCase(); 
      if (extFile !== "png"){ 
            alert("Solo imagenes en formato PNG"); 
            return;
      }
      await fetch("/app_asistencia/controllers/updatefotouser.php?tipouserfoto=1&dni="+DNI_DOC_EDIT,{
            method:'POST',
            body:datosUser
      })
      .then( res => res.json())
      .then( data => {
            if(data === 'actualizadosi'){
                  alert("Foto actualizada, correctamente");
                  location.reload();
            }else{
                  alert("Fallo la actualizacion :c");
            }

      })
}
const eliminarfoto_d = async () => {
      await fetch("/app_asistencia/controllers/updatefotouser.php?tipouserfoto=0&dni="+DNI_DOC_EDIT)
      .then( res => res.json())
      .then( data => {
            if(data === 'eliminadosi'){
                  alert("Foto eliminada, correctamente");
                  location.reload();
            }else{
                  alert("Fallo la actualizacion :c");
            }
      })
}

btnfotoup_d.addEventListener("click", () => { if(confirm("¿Desea Actualizar su Foto?")) actualizarfoto_d();});
btnfotodel_d.addEventListener("click", () => { if(confirm("¿Desea Eliminar su Foto?"))  eliminarfoto_d();});





