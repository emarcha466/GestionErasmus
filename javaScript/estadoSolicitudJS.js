window.addEventListener('load', function () {
    let btnConsultar = this.document.getElementById("btnConsultar")

    btnConsultar.addEventListener('click', function (ev) {
        ev.preventDefault()

        //compruebo si existe la solicitud
        if (this.form.valida()) {
            let solicitud = document.getElementById("solicitud")
            let dni = document.getElementById("dni")
            let pass = document.getElementById("contrasena")

            fetch("./api/SolicitudApi.php?id=" + encodeURIComponent(solicitud.value) + "&dni=" + encodeURIComponent(dni.value) + "&pass=" + encodeURIComponent(pass.value), {
                method: 'GET'
            })
                .then(x => x.json())
                .then(solicitud => {
                    if (!solicitud) {
                        muestraError("No se ha encontrado solicitud con los credenciales proporcionados")
                    } else {

                        fetch("./api/ConvocatoriaApi.php/?id="+encodeURIComponent(solicitud.idConvocatoria)+"&date",{
                            method:'GET'
                        })
                        .then(x=>x.json())
                        .then(y=>{
                            if(y=="SOLICITUD"){
                                abrirModal(solicitud.idConvocatoria, solicitud.id, solicitud.dni)
                            }else if(y=="PRUEBAS"){
                                alert("La solicitud se encuentra en el periodo de entrevistas")
                            }else if(y=="LISTADO_PROVISIONAL"){
                                alert("Se ha publicado el listado provisional")
                            }else if(y=="LISTADO_DEFINITIVO"){
                                alert("Se ha publicado el istado definitivo")
                            }
                        })
                        
                    }
                })

        } else {
            muestraError("Por favor, revise los datos introducidos")
        }

    })

    function abrirModal(idConvocatoria, idSolicitud, dni) {
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
        visualizador.id = "modalSolicitud"
        visualizador.classList.add("estrucutraModal")
        visualizador.style.position = "fixed"
        visualizador.style.left = "15%"
        visualizador.style.top = "3%"
        visualizador.style.width = "70%";
        visualizador.style.height = "90%";
        visualizador.style.backgroundColor = "white"
        visualizador.style.zIndex = 100
        document.body.appendChild(visualizador)

        var closer = document.createElement("img")
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
                nombre.innerHTML = "Requerido"
                nota.innerHTML = "Archivo"
                cabecera.appendChild(nombre)
                cabecera.appendChild(nota)
                table.appendChild(cabecera)

                bare.forEach(function (item) {
                    //para mostrar solos los items que debe aportar el alumno
                    if (item.aportaAlumno == "si") {
                        var tr = document.createElement('tr');
                        var cell1 = document.createElement('td');
                        var cell2 = document.createElement('td');
                        var cell3 = document.createElement('td');
                        cell1.innerHTML = item.nombre;

                        //input para subir el pdf
                        let filePDF = document.createElement('input')
                        filePDF.type = "file"
                        filePDF.classList ="pdfItem"
                        filePDF.name = "pdf[]"
                        filePDF.dataset.id_item = item.idItemBaremable
                        filePDF.dataset.id_convocatoria = item.idConvocatoria
                        filePDF.dataset.id_solicitud = item.idSolicitud
                        cell2.appendChild(filePDF)

                        //input para ver el pdf subido
                        let btnPDF = document.createElement('input')
                        btnPDF.type = "button"
                        btnPDF.value = "Mostrar PDF Subido"
                        btnPDF.onclick =function(){
                            if(item.url != null){
                                muestraPdf(item.url, visualizador)
                            }
                        }
                        cell3.appendChild(btnPDF)

                        tr.appendChild(cell1);
                        tr.appendChild(cell2);
                        tr.appendChild(cell3);
                        table.appendChild(tr);
                    }
                });
                visualizador.appendChild(table);

                //creo el boton para realizar baremacion
                let btnSolicitud = document.createElement("input")
                btnSolicitud.type = "button"
                btnSolicitud.classList.add("btnPantalla")
                btnSolicitud.value = "Finalizar Solicitud"
                btnSolicitud.onclick=function(){
                    let inputs = Array.from(document.getElementsByClassName("pdfItem"))
                    let isValid = true;

                    inputs.forEach(input => {
                        if (!input.files.length) {
                            isValid = false;
                        }
                    });
                    if(!isValid){
                        alert('Debe proporcionar todos los documentos');

                    }
                
                    if (isValid) {
                        let data = new FormData()
                    
                    let idItems = []
                    inputs.forEach(input => {
                        console.log(input.dataset.id_convocatoria + "_" + input.dataset.id_solicitud + "_" + input.dataset.id_item + "_"+dni)
                        let fileName = input.dataset.id_convocatoria + "_" + input.dataset.id_solicitud + "_" + input.dataset.id_item + "_"+dni;
                        data.append(fileName, input.files[0]);
                        idItems.push(input.dataset.id_item)
                    });
                    data.append("idSolicitud", idSolicitud)
                    data.append("idConvocatoria", idConvocatoria)
                    data.append("idItems", idItems)

                    fetch('./api/BaremacionApi.php/?subirPDF', {
                        method: 'POST',
                        body: data
                    })
                    .then(response => response.json())
                    .then(result => {
                        location.href="?menu=estadoSolicitudLogin"
                    });
                }
                }
                visualizador.appendChild(btnSolicitud)
            })
    }

    //funcion que envia los pdfs a la api
    function enviarPDFs(idConvocatoria, idSolicitud, itemsDoc){
        let data = {
            "idConvocatoria": idConvocatoria,
            "idSolicitud": idSolicitud,
            "itemsDoc": itemsDoc
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
})