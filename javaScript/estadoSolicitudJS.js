window.addEventListener('load', function(){
    let btnConsultar = this.document.getElementById("btnConsultar")

    btnConsultar.addEventListener('click', function(ev){
        ev.preventDefault()

        if(this.form.valida()){
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
                    abrirModal(convocatoria, dni, pass)
                }
            })
    
        }else{
            muestraError("Debe rellenar todos los campos")
        }
        
    })

    function abrirModal(idConvocatoria, dni, pass) {
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
                bare.forEach(function (item) {
                    var tr = document.createElement('tr');
                    var cell1 = document.createElement('td');
                    var cell2 = document.createElement('td');
                    cell1.innerHTML = item.nombre;

                    //input para la nota
                    let input = document.createElement('input')
                    input.type = "number"
                    input.value = item.notaProvisional || ''
                    input.min =0
                    input.max = item.importancia
                    input.dataset.id_item = item.idItemBaremable
                    cell2.appendChild(input)

                    // Agregar evento de clic a la celda
                    cell1.addEventListener('click', function () {
                        if(item.aportaAlumno=="si"){
                            muestraPdf(item.url, visualizador);
                        }
                        
                    });

                    tr.appendChild(cell1);
                    tr.appendChild(cell2);
                    table.appendChild(tr);
                });
                visualizador.appendChild(table);

                //creo el boton para realizar baremacion
                let btnBaremacion = document.createElement("input")
                btnBaremacion.type="button"
                btnBaremacion.classList.add("btnPantalla")
                btnBaremacion.value="Realizar Baremacion"
                visualizador.appendChild(btnBaremacion)
            })
    }
})