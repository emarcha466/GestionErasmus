window.addEventListener('load', function () {

    let duracion = this.document.getElementById("duracion")
    let selectTipo = this.document.getElementById("tipo")
    let destinatariosDiv = this.document.getElementById("destinatariosConvo")
    let itemsDiv = this.document.getElementById("itemBaremablesConvo")
    let checkboxDestinatario = document.getElementsByName('destinatario');
    let tbody = this.document.getElementById("tbItemBaremables");

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
            destinatarios.forEach(destinatario => {
                const label = this.document.createElement('label')
                const input = this.document.createElement('input')
                input.type = "checkbox"
                input.name = "destinatario"
                input.value = destinatario.codigoGrupo;
                label.appendChild(input)
                label.innerHTML += destinatario.codigoGrupo;
                destinatariosDiv.append(label)
            })
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
                        nombre.innerHTML = item.nombre;
                        requisito.value = "no";
                        aportaAlumno.value = "no";

                        tbody.appendChild(fila);

                        chexbox.onchange = function() {
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
})