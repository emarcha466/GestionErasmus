window.addEventListener('load', function () {
    let tbody = this.document.getElementById("tbodyListadoRevisionSolicitudes");
    let tbodyConvocatorias = this.document.getElementById("tbodyListadoConvocatorias");

    actualizar();
    function actualizar() {

        //relleno la tabla con las convocatorias segun la plantilla
        fetch("./views/plantillas/listadoConvocatorias.html")
            .then(x => x.text())
            .then(tr => {

                tbodyAux = document.createElement("tbody");
                tbodyAux.innerHTML = tr;
                var filaC = tbodyAux.children[0];
                //llamo a la API para recoger las convocatorias
                fetch("./api/ConvocatoriaApi.php")
                    .then(x => x.json())
                    .then(convocatorias => {
                        tbodyConvocatorias.replaceChildren();

                        convocatorias.forEach(convocatoria => {
                            var fila = filaC.cloneNode(true);

                            var duracion = fila.querySelector(".duracionConvocatoria");
                            var tipo = fila.querySelector(".tipoConvocatoria");
                            var inicio = fila.querySelector(".inicioSolicitues");
                            var fin = fila.querySelector(".finSolicitudes");
                            var destino = fila.querySelector(".destinoConvocatoria");
                            var btn = fila.querySelector(".btnRealizarSolicitud");

                            duracion.innerHTML = (convocatoria.duracion + " días");
                            tipo.innerHTML = convocatoria.tipo;
                            inicio.innerHTML = cambiarFormatoFecha(convocatoria.fechaIniSolicitud);
                            fin.innerHTML = cambiarFormatoFecha(convocatoria.fechaFinSolicitud);
                            destino.innerHTML = convocatoria.destino;
                            btn.value = "Ver solicitudes"

                            btn.onclick = function () {
                                mostrarSolicitudes(convocatoria.id);
                            }

                            tbodyConvocatorias.appendChild(fila);
                        });
                    })

            })
    }




    function mostrarSolicitudes(idConvocatoria) {

        //relleno la tabla con las solicitudes segun la plantilla
        fetch("./views/plantillas/listadoSolicitudes.html")
            .then(x => x.text())
            .then(tr => {

                tbodyAux = document.createElement("tbody");
                tbodyAux.innerHTML = tr;
                var filaC = tbodyAux.children[0];
                //llamo a la API para recoger las convocatorias
                fetch("./api/SolicitudApi.php?idConvocatoria="+encodeURIComponent(idConvocatoria))
                    .then(x => x.json())
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


    /**
 * Funcion que devuelve la fecha actual en formato yyyy-mm-dd
 * 
 * @returns string Fecha actual en formato yyyy-mm-dd
 */
    function FechaActual() {
        let fecha = new Date();
        let dia = String(fecha.getDate()).padStart(2, '0');
        let mes = String(fecha.getMonth() + 1).padStart(2, '0'); // Los meses en JavaScript comienzan desde 0
        let año = fecha.getFullYear();

        return `${año}-${mes}-${dia}`;
    }
    /**
     * Funcion que cambia la fecha de formato yyyy-mm-dd a dd-mm-yyyy
     * 
     * @param {string} fecha 
     * @returns Fecha en formato dd-mm-yyyy
     */
    function cambiarFormatoFecha(fecha) {
        let partes = fecha.split('-');
        let año = partes[0]
        let mes = partes[1];
        let dia = partes[2];

        return `${dia}-${mes}-${año}`;
    }


})