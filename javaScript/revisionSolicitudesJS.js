window.addEventListener('load',function(){
    let tbody = this.document.getElementById("tbodyListadoRevisionSolicitudes");

    actualizar();
    function actualizar(){

        //relleno la tabla con las solicitudes segun la plantilla
        fetch("./views/plantillas/listadoSolicitudes.html")
        .then(x => x.text())
        .then(tr =>{

            tbodyAux = document.createElement("tbody");
            tbodyAux.innerHTML=tr;
            var filaC = tbodyAux.children[0];
            //llamo a la API para recoger las convocatorias
            fetch("./api/SolicitudApi.php")
            .then(x=> x.json())
            .then(solicitudes => {
                tbody.replaceChildren();

                solicitudes.forEach(solicitud => {
                    var fila = filaC.cloneNode(true);

                    var dni = fila.querySelector(".dni");
                    var apellidos = fila.querySelector(".apellidos");
                    var nombre = fila.querySelector(".nombre");
                    var fechaNac = fila.querySelector(".fechaNac");
                    var telefono = fila.querySelector(".telefono");
                    var correo = fila.querySelector(".correo");
                    var id = fila.querySelector(".id")
                    var idConvocatoria = fila.querySelector(".idConvocatoria")

                    dni.innerHTML = solicitud.dni
                    apellidos.innerHTML = solicitud.apellidos
                    nombre.innerHTML = solicitud.nombre
                    fechaNac.innerHTML = solicitud.fechaNac
                    telefono.innerHTML = solicitud.telefono
                    correo.innerHTML = solicitud.correo
                    id.value = solicitud.id
                    idConvocatoria.value = solicitud.idConvocatoria
                    
                    tbody.appendChild(fila);
                });
            })

        })
    }
})