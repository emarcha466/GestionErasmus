window.addEventListener('load', function(){
    let btnConsultar = this.document.getElementById("btnConsultar")

    btnConsultar.addEventListener('click', function(ev){
        ev.preventDefault()

        let convocatoria = document.getElementById("convocatoria")
        let dni = document.getElementById("dni")
        let pass = document.getElementById("contrasena")

        fetch("./api/SolicitudApi.php?id="+encodeURIComponent(convocatoria.value)+"&dni="+encodeURIComponent(dni.value)+"&pass="+encodeURIComponent(pass.value),{
            method: 'GET'
        })
        .then(x=>x.json())
        .then(y=>{
            if(!y){
                muestraError("No se ha encontrado ninguna solicitud con esos credenciales")
            }else{
                
            }
        })

    })
})