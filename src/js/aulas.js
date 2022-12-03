const limpiarx = document.getElementById("btnlimpiarx");
const crearaulax = document.getElementById("btncrearaula");

const nomaula = document.getElementById("nom_aulax");
const desaula = document.getElementById("des_aulax");
const espaciodoc = document.getElementById("espacio_doc");

limpiarx.addEventListener("click", (e)=>{
    e.preventDefault();
    nomaula.value = '';
    desaula.value = '';
});

crearaulax.addEventListener("click", async (e)=>{
    e.preventDefault();
    if(desaula.value != '' || nomaula.value != ''){
        await fetch("/app_asistencia/controllers/crearAula.php?nom="+nomaula.value+"&des="+desaula.value)
        .then( res => res.json())
        .then( data => {
            if(data==='listo'){
            alert("Aula creada");    
            location.reload();
            }
        }) 
    }else{
        alert("Completar campos");
    }
});


let listarApo = null; 
let htmlDoc = '';
async function mostrarDocente(ida){
        await fetch("/app_asistencia/controllers/mostrarDocAula.php?idaula="+ida)
        .then( res => res.json())
        .then( data => {
            if(data[0]==='no'){
                alert("No tiene ningun docente");
                htmlDoc =
                    `<hr>
                    <h4>No tiene Docente Asignado</h4>
                 
                    `;
            }else{
                htmlDoc = '';
                for(i = 1; i < data.length; i++){
                    htmlDoc +=
                    `<hr>
                    <h4>Nombre Completo:</h4>
                    <p>`+data[i].nombre +" "+ data[i].apellido+`</p><br>
                    <h4>DNI:</h4>
                    <p>`+data[i].dni+`</p><br>
                    `;
            
                }  
            }
            listarDocAula(htmlDoc); 
        })  
}

function listarDocAula(html){
    if(listarApo != null){
        listarApo.remove();
    }
    listarApo = document.createElement('div');
    listarApo.innerHTML= html;
    espaciodoc.append(listarApo);
}


