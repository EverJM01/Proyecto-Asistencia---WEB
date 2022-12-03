const btnfotoup = document.getElementById("fotomod");
const btnfotodel = document.getElementById("fotodel");

const dniuserfoto = document.dniuserglobal;
const filefoto = document.getElementById("fotofile"); 

const actualizarfoto = async () => {
      let datosUser = new FormData();
      datosUser.append("archivofoto", filefoto.files[0])
      const fileName = filefoto.value; 
      const idxDot = fileName.lastIndexOf(".") + 1; 
      const extFile = fileName.substr(idxDot, fileName.length).toLowerCase(); 
      if (extFile !== "png"){ 
            alert("Solo imagenes en formato PNG"); 
            return;
      }
      await fetch("/app_asistencia/controllers/updatefotouser.php?tipouserfoto=1&dni="+dniuserfoto,{
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
const eliminarfoto = async () => {
      await fetch("/app_asistencia/controllers/updatefotouser.php?tipouserfoto=0&dni="+dniuserfoto)
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

btnfotoup.addEventListener("click", () => { if(confirm("¿Desea Actualizar su Foto?")) actualizarfoto();});
btnfotodel.addEventListener("click", () => { if(confirm("¿Desea Eliminar su Foto?"))  eliminarfoto();});

