const formulario = document.getElementById("formUpdateUser");
const dniuser = document.dniuserglobal;
const validacion = async (e) => {
      e.preventDefault();
      const datosUser = new FormData(formulario);

      const pass = datosUser.get("_pass");
      const direccion = datosUser.get("_direccion");
 
      const correo = datosUser.get("_correo");
      const telefono = datosUser.get("_telefono");
   

      if(pass.length > 6){
            alert("Contraseña no admitido");
            return;
      }

      if(telefono.length !== 9){
            alert("Telefono no admitido");
            return;
      }


      const confirmacion = confirm("¿Deseas Actualizar tu información?");
      if(confirmacion){
            await fetch("/app_asistencia/controllers/updateuserme2.php?dniuser="+dniuser, {
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


formulario.addEventListener("submit", validacion);
