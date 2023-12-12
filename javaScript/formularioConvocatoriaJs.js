window.addEventListener('load', function () {

    let duracion = this.document.getElementById("duracion")
    let selectTipo = this.document.getElementById("tipo")
    let destinatariosDiv = this.document.getElementById("destinatariosConvo")
    let itemsDiv = this.document.getElementById("itemBaremablesConvo")
    let checkboxDestinatario = document.getElementsByName('destinatario');
    let tbody = this.document.getElementById("tbItemBaremables");
    let divNotaIdioma = this.document.getElementById("puntuacionIdioma")
    let tbodyIdioma = document.getElementById("tbodyPuntosIdioma")

    //recogo el id en el localStorage para rellenar los datos en el caso de actualizacion
    let idConvocatoria = localStorage.getItem('idConvocatoria');

    //rellenar el select de proyecto
    fetch("./api/ProyectoApi.php", {
        method: 'GET'
    })
        .then(x => x.json())
        .then(proyectos => {
            var selectProyecto = this.document.getElementById("proyecto")
            proyectos.forEach(proyecto => {
                const option = document.createElement('option');
                option.value = proyecto.codigoProyecto;
                option.text = proyecto.nombreProyecto;
                selectProyecto.appendChild(option);
            });
        })

    //rellenar los destinatarios
    this.fetch("./api/DestinatarioApi.php", {
        method: 'GET'
    })
        .then(x => x.json())
        .then(destinatarios => {
            if (idConvocatoria) {
                this.fetch("./api/ConvocatoriaDestinatarioApi.php/?idConvocatoria=" + idConvocatoria, {
                    method: 'GET'
                })
                    .then(x => x.json())
                    .then(destinatariosConvo => {
                        let codigosGrupoConvo = destinatariosConvo.map(destinatario => destinatario.codigoGrupo);
                        console.log(codigosGrupoConvo);
                        destinatarios.forEach(destinatario => {
                            const label = this.document.createElement('label')
                            const input = this.document.createElement('input')
                            input.type = "checkbox"
                            input.name = "destinatario[]"
                            input.value = destinatario.codigoGrupo;
                            // Si el destinatario está en la lista de destinatarios de la convocatoria lo marco
                            if (codigosGrupoConvo.includes(destinatario.codigoGrupo)) {
                                console.log(true)
                                input.checked = true;
                            }

                            label.appendChild(input)
                            label.innerHTML += destinatario.codigoGrupo;
                            destinatariosDiv.append(label)
                        })
                    })
            } else {
                destinatarios.forEach(destinatario => {
                    const label = this.document.createElement('label')
                    const input = this.document.createElement('input')
                    input.type = "checkbox"
                    input.name = "destinatario[]"
                    input.value = destinatario.codigoGrupo;
                    label.appendChild(input)
                    label.innerHTML += destinatario.codigoGrupo;
                    destinatariosDiv.append(label)
                })
            }
        })

    //rellenar los itemsBaremables
    fetch("./views/plantillas/listadoItemBaremableConvocatoria.html")
        .then(x => x.text())
        .then(tr => {
            tbodyAux = document.createElement("tbody");
            tbodyAux.innerHTML = tr;
            var filaC = tbodyAux.children[0];

            this.fetch("./api/ItemBaremableApi.php", {
                method: 'GET'
            })
                .then(x => x.json())
                .then(items => {

                    items.forEach(item => {
                        var fila = filaC.cloneNode(true);
                        var nombre = fila.querySelector(".nombreItem");
                        var chexbox = fila.querySelector(".checkItem");
                        var aportaAlumno = fila.querySelector(".aportaAlumnoItem");
                        var requisito = fila.querySelector(".requsitoItem")

                        chexbox.value = item.id;
                        if (chexbox.value == 1) {
                            chexbox.addEventListener('change', function (event) {
                                mostrarNotaIdioma(event.target.checked)
                            })
                        }
                        nombre.innerHTML = item.nombre;
                        requisito.value = "no";
                        aportaAlumno.value = "no";
                        var hiddenInput = document.createElement("input");
                        hiddenInput.type = "hidden";
                        hiddenInput.name = "nombreItem[]";
                        hiddenInput.value = item.nombre;
                        nombre.parentNode.insertBefore(hiddenInput, nombre.nextSibling);

                        tbody.appendChild(fila);

                        chexbox.onchange = function () {
                            //cojo los datos de la fila, menos el checkbox
                            var inputs = this.parentNode.parentNode.querySelectorAll('input:not(.checkItem), select');

                            //deshabilito o habilito cada casilla de la tabla
                            for (var j = 0; j < inputs.length; j++) {
                                // Si la casilla de verificación esta marcada
                                if (this.checked) {
                                    // Habilito el elemento de entrada
                                    inputs[j].disabled = false;
                                } else {
                                    // Deshabilito el elemento de entrada
                                    inputs[j].disabled = true;
                                }
                            }
                        };
                    })
                })
        })


    duracion.addEventListener('change', function () {
        if (this.value <= 90) {
            selectTipo.value = "corta duracion"
        } else {
            selectTipo.value = "larga duracion"
        }
    })

    function mostrarNotaIdioma(activo) {
        console.log(activo)
        if (activo) {
            divNotaIdioma.style.display = ""
            tablaNotaIdioma()
        } else {
            divNotaIdioma.style.display = "none"
            tbodyIdioma.replaceChildren()
        }
    }

    function tablaNotaIdioma() {

        fetch("./views/plantillas/listadoConvocatoriaBaremoIdioma.html")
            .then(x => x.text())
            .then(tr => {
                tbodyAux = document.createElement("tbody");
                tbodyAux.innerHTML = tr;
                var filaC = tbodyAux.children[0];

                this.fetch("./api/NivelIdiomaApi.php", {
                    method: 'GET'
                })
                    .then(x => x.json())
                    .then(items => {

                        items.forEach(item => {
                            var fila = filaC.cloneNode(true);
                            let idIdioma = fila.querySelector(".idNivelIdioma");
                            var nombreIdioma = fila.querySelector(".nombreIdioma");

                            idIdioma.value = item.id;
                            nombreIdioma.innerHTML = item.nombre;
                            tbodyIdioma.appendChild(fila);
                        })
                    })
            })
    }
})