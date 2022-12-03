const horaIniciotxt = document.getElementById("hora_tempranox");
const horaTardetxt = document.getElementById("hora_tardanzax");
const horaFaltatxt = document.getElementById("hora_faltax");

const btnlimpiarx = document.getElementById("btnLimpiarx");
const btnestho = document.getElementById("btnEstablecerx");

btnlimpiarx.addEventListener("click", () => {
    horaIniciotxt.value = '';
    horaTardetxt.value = '';
    horaFaltatxt.value = '';
});

btnestho.addEventListener("click", async () => {
    if(horaFaltatxt.value == '' || horaTardetxt.value == '' || horaIniciotxt.value == ''){
        alert("Completar todos los campos");
        return;
    }
    await fetch("/app_asistencia/controllers/actualizarHorario.php?inicio="+horaIniciotxt.value+"&tarde="+horaTardetxt.value+"&falta="+horaFaltatxt.value)
    .then( res => res.json())
    .then( data => {
            if(data==='listo'){
            alert("Horario actualizado");   
            location.reload(); 
            }
    }) 
}); 


