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
                fetch("./api/SolicitudApi.php?idConvocatoria=" + encodeURIComponent(idConvocatoria))
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
                            var btnBaremacion = fila.querySelector(".baremacion")

                            dni.innerHTML = solicitud.dni
                            apellidos.innerHTML = solicitud.apellidos
                            nombre.innerHTML = solicitud.nombre
                            fechaNac.innerHTML = solicitud.fechaNac
                            telefono.innerHTML = solicitud.telefono
                            correo.innerHTML = solicitud.correo
                            id.value = solicitud.id
                            idConvocatoria.value = solicitud.idConvocatoria
                            btnBaremacion.onclick = function (ev) {
                                ev.preventDefault()
                                baremar(solicitud.idConvocatoria, solicitud.id)
                            }

                            tbody.appendChild(fila);
                        });
                    })

            })
    }


    function baremar(idConvocatoria, idSolicitud) {
        //fondo modal
        var modal = document.createElement("div")
        modal.style.position = "fixed"
        modal.style.left = 0
        modal.style.top = 0
        modal.style.width = "100%";
        modal.style.height = "100%";
        modal.style.backgroundColor = "rgba(0,0,0,0.5)"
        modal.style.zIndex = 99
        document.body.appendChild(modal)

        //visualizador
        var visualizador = document.createElement("div")
        visualizador.id = "modalBaremo"
        visualizador.style.position = "fixed"
        visualizador.style.left = "15%"
        visualizador.style.top = "3%"
        visualizador.style.width = "70%";
        visualizador.style.height = "90%";
        visualizador.style.backgroundColor = "white"
        visualizador.style.zIndex = 100
        document.body.appendChild(visualizador)

        var closer = document.createElement("img")
        closer.classList.add("closer")
        closer.src = "./recursos/img/cerrar.png"
        closer.width = 30
        closer.style.position = "fixed"
        closer.style.top = 0
        closer.style.right = 0
        closer.style.zIndex = 101
        document.body.appendChild(closer)

        closer.onclick = function () {
            document.body.removeChild(modal)
            document.body.removeChild(visualizador)
            document.body.removeChild(this)
        }



        //llamada para traerme la baremacion
        fetch("./api/BaremacionApi.php?idConvocatoria=" + encodeURIComponent(idConvocatoria) + "&idSolicitud=" + encodeURIComponent(idSolicitud), {
            method: 'GET'
        })
            .then(x => x.json())
            .then(bare => {


                // Crear tabla
                var table = document.createElement('table');
                table.id = "tbBaremaciones"
                let cabecera = document.createElement('tr');
                let nombre = document.createElement('th');
                let nota = document.createElement('th');
                nombre.innerHTML = "Item"
                nota.innerHTML = "Nota"
                cabecera.appendChild(nombre)
                cabecera.appendChild(nota)
                table.appendChild(cabecera)


                //Creo la tabla con los items baremables
                bare.forEach(function (item) {
                    var tr = document.createElement('tr');
                    var cell1 = document.createElement('td');
                    var cell2 = document.createElement('td');
                    cell1.innerHTML = item.nombre;

                    //input para la nota
                    let input = document.createElement('input')
                    input.type = "number"
                    input.classList.add("notasItems")
                    input.value = item.notaProvisional || ''
                    input.min = 0
                    input.max = item.importancia
                    input.dataset.id_item = item.idItemBaremable
                    cell2.appendChild(input)

                    // Agregar evento de clic a la celda
                    cell1.addEventListener('click', function () {
                        if (item.aportaAlumno == "si") {
                            muestraPdf(item.url, visualizador);
                        } else {
                            let visorAntiguo = document.querySelector('#pdfViewer');
                            if (visorAntiguo) {
                                visualizador.removeChild(visorAntiguo);
                            }
                        }

                    });

                    tr.appendChild(cell1);
                    tr.appendChild(cell2);
                    table.appendChild(tr);

                    //guardo los datos del item 
                });
                visualizador.appendChild(table);

                //creo el boton para realizar baremacion
                let btnBaremacion = document.createElement("input")
                btnBaremacion.type = "button"
                btnBaremacion.classList.add("btnPantalla")
                btnBaremacion.value = "Realizar Baremacion"
                visualizador.appendChild(btnBaremacion)
                btnBaremacion.onclick = function () {
                    const arrayNotas = []
                    let itemsNotas = Array.from(document.getElementsByClassName("notasItems"))
                    itemsNotas.forEach(item => {

                        arrayNotas.push({
                            'idItem': item.dataset.id_item,
                            'nota': item.value
                        });
                    })
                    realizarBaremacion(idConvocatoria, idSolicitud, arrayNotas)
                }
            })
    }

    //Realizar la baremacion
    function realizarBaremacion(idConvocatoria, idSolicitud, items) {
        let data = {
            "idConvocatoria": idConvocatoria,
            "idSolicitud": idSolicitud,
            "itemsNotas": items
        }

        fetch("./api/BaremacionApi.php", {
            method: "PUT",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(x => x.json())
            .then(y => {
                if(y.status="success"){
                    muestraCorrecto(y.message)
                    document.getElementsByClassName("closer")[0].click()
                }
            })
    }


    // Función para mostrar el PDF
    function muestraPdf(url, contenedor) {
        // Si ha un visor antiguo lo elimino
        var visorAntiguo = document.querySelector('#pdfViewer');
        if (visorAntiguo) {
            contenedor.removeChild(visorAntiguo);
        }

        // Crear nuevo visor de PDF
        var pdfViewer = document.createElement('iframe');
        pdfViewer.id = 'pdfViewer';
        pdfViewer.style.width = '100%';
        pdfViewer.style.height = '70%';
        pdfViewer.src = url;
        contenedor.appendChild(pdfViewer);
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