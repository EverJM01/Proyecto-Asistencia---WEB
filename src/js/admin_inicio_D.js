const item1d = document.getElementById("item1");
const item2 = document.getElementById("item2");
const item5 = document.getElementById("item5");
const item6 = document.getElementById("item6");

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

