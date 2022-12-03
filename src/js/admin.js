window.addEventListener('DOMContentLoaded', event => {
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }
});


const validarCambioFoto = document.getElementById("validarcambiofoto");

const fotomod = document.getElementById("fotomod");
const fotodel = document.getElementById("fotodel");
const fotofile = document.getElementById("fotofile");


validarCambioFoto.addEventListener("change", ()=>{
    if(validarCambioFoto.checked){
        fotomod.disabled = false;
        fotodel.disabled = false;
        fotofile.disabled = false;
    }else{         
        fotomod.disabled = true;
        fotodel.disabled = true;
        fotofile.disabled = true;
    }
});





