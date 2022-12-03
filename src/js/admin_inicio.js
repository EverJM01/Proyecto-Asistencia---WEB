const item1d = document.getElementById("item1");
const item2 = document.getElementById("item2");
const item5 = document.getElementById("item5");
const item6 = document.getElementById("item6");
const item7 = document.getElementById("item7");
const item8 = document.getElementById("item8");
const item9 = document.getElementById("item9");
const item10 = document.getElementById("item10");

item1d.addEventListener("click", ()=>{
    window.location.href = "/app_asistencia/views/user_estudiantes.php";
});
item2.addEventListener("click", ()=>{
    window.location.href = "/app_asistencia/views/user_asistencias_general.php";
});

item5.addEventListener("click", ()=>{
    window.location.href = "/app_asistencia/views/user_codigoqr.php";
});
item6.addEventListener("click", ()=>{
    window.location.href = "/app_asistencia/views/user_reportes.php";
});

item7.addEventListener("click", ()=>{
    window.location.href = "/app_asistencia/views/user_docentes.php";
});
item8.addEventListener("click", ()=>{
    window.location.href = "/app_asistencia/views/user_adicional_horario.php";
});
item9.addEventListener("click", ()=>{
    window.location.href = "/app_asistencia/views/user_adicional_aulas.php";
});
item10.addEventListener("click", ()=>{
    window.location.href = "/app_asistencia/views/user_adicional_apoderados.php";
});
