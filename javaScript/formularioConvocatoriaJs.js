window.addEventListener('load', function(){

    let duracion = this.document.getElementById("duracion")
    let selectTipo = this.document.getElementById("tipo")
    //rellenar el select de proyecto
    fetch("./api/ProyectoApi.php",{
        method:'GET'
    })
    .then(x=>x.json())
    .then(proyectos =>{
        var selectProyecto = this.document.getElementById("proyecto")
        proyectos.forEach(proyecto => {
            const option = document.createElement('option');
                option.value = proyecto.codigoProyecto;
                option.text = proyecto.nombreProyecto;
                selectProyecto.appendChild(option);
        });
    })

    duracion.addEventListener('change',function(){
        if(this.value<=90){
            selectTipo.value="corta duracion"
        }else{
            selectTipo.value="larga duracion"
        }
    })


})