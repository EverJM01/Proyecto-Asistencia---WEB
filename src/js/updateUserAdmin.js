const formulario = document.getElementById("formUpdateUser");
const dniuser = document.dniuserglobal;
const validacion = async (e) => {
      e.preventDefault();
      const datosUser = new FormData(formulario);

      const dni = datosUser.get("_dni");
      const pass = datosUser.get("_pass");
      const telefono = datosUser.get("_telefono");
      

      if(dni.length !== 8){
            alert("DNI no admitido");
            return;
      }

      if(pass.length > 6){
            alert("Contraseña no admitido\n(6 caracteres maximo)");
            return;
      }
      if(telefono.length !== 9){
            alert("Telefono no admitido");
            return;
      }
      let admitir = 0;

      if(dni !== dniuser.toString()){
           
            await fetch("/app_asistencia/controllers/validarDni.php", {
                  method: 'POST',
                  body: datosUser
            })
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
           
            const confirmacion = confirm("¿Deseas Actualizar tu información?");
            if(confirmacion){
                 await fetch("/app_asistencia/controllers/updateuserme.php?dniuser="+dniuser, {
                  method: 'POST',
                  body: datosUser
                  })
                  .then( res => res.json())
                  .then( data => {
                        if(data === 'listoupdate'){
                              alert("se actualizo correctamente sus datos");
                              location.reload();
                        }                 
                  }) 
            }else{
                  return;
            }
            
      }
}


formulario.addEventListener("submit", validacion);
