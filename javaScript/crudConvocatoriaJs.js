window.addEventListener('load', function () {
    let tbody = this.document.getElementById("tbodyListadoConvocatorias");
    var mensajes = document.querySelectorAll('p.error, p.success');

    actualizar();

    function actualizar() {
        //relleno la tabla con las convocatorias segun la plantilla
        fetch("./views/plantillas/listadoConvocatoriasCompleto.html")
            .then(x => x.text())
            .then(tr => {

                tbodyAux = document.createElement("tbody");
                tbodyAux.innerHTML = tr;
                var filaC = tbodyAux.children[0];
                //llamo a la API para recoger las convocatorias
                fetch("./api/ConvocatoriaApi.php")
                    .then(x => x.json())
                    .then(convocatorias => {
                        tbody.replaceChildren();

                        convocatorias.forEach(convocatoria => {
                            var fila = filaC.cloneNode(true);
                            console.log(fila)

                            var id = fila.querySelector(".idConvocatoria");
                            var proyecto = fila.querySelector(".proyectoConvocatoria");
                            var duracion = fila.querySelector(".duracionConvocatoria");
                            var movilidades = fila.querySelector(".numMovilidadesConvocatoria")
                            var tipo = fila.querySelector(".tipoConvocatoria");
                            var inicioSolicitudes = fila.querySelector(".inicioSolicitues");
                            var finSolicitudes = fila.querySelector(".finSolicitudes");
                            var inicioPruebas = fila.querySelector(".inicioPruebas");
                            var finPruebas = fila.querySelector(".finPruebas");
                            var listadoProvisional = fila.querySelector(".listadoProvisional");
                            var listadoDefinitivo = fila.querySelector(".listadoDefinitivo");
                            var destino = fila.querySelector(".destinoConvocatoria");

                            id.value = convocatoria.id
                            id.style.display = "none"
                            proyecto.value = convocatoria.codigoProyecto
                            movilidades.value = convocatoria.num_movilidades
                            duracion.value = (convocatoria.duracion + " días");
                            tipo.value = convocatoria.tipo;
                            inicioSolicitudes.value = cambiarFormatoFecha(convocatoria.fechaIniSolicitud);
                            finSolicitudes.value = cambiarFormatoFecha(convocatoria.fechaFinSolicitud);
                            inicioPruebas.value = cambiarFormatoFecha(convocatoria.fechaIniPruebas)
                            finPruebas.value = cambiarFormatoFecha(convocatoria.fechaFinPruebas)
                            listadoProvisional.value = cambiarFormatoFecha(convocatoria.fechaListadoProvisional)
                            listadoDefinitivo.value = cambiarFormatoFecha(convocatoria.fechaListadoDefinitivo)
                            destino.value = convocatoria.destino;

                            tbody.appendChild(fila);
                        });
                    })

            })
    }

    //funcion que elimina los mensajes del formulario
    mensajes.forEach(mensaje=>{
        setTimeout(function() {
            mensaje.remove();
        }, 2000);
    })

    /**
     * Funcion que cambia la fecha de formato yyyy-mm-dd a dd-mm-yyyy
     * 
     * @param {string} fecha 
     * @returns Fecha en formato dd-mm-yyyy
     */
    function cambiarFormatoFecha(fecha) {
        let partes = fecha.split('-');
        let año = partes[0].slice(-2); // Obtiene los últimos dos dígitos del año
        let mes = partes[1];
        let dia = partes[2];

        return `${dia}-${mes}-${año}`;
    }
})