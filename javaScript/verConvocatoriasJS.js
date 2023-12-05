window.addEventListener('load', function(){
    tbody = this.document.getElementById("tbodyListadoConvocatorias");


    actualizar();
    function actualizar(){

        //relleno la tabla con las convocatorias segun la plantilla
        fetch("./views/plantillas/listadoConvocatorias.html")
        .then(x => x.text())
        .then(tr =>{

            tbodyAux = document.createElement("tbody");
            tbodyAux.innerHTML=tr;
            var filaC = tbodyAux.children[0];
            var date = FechaActual();
            //llamo a la API para recoger las convocatorias
            fetch("./api/ConvocatoriaApi.php?date="+encodeURIComponent(date))
            .then(x=> x.json())
            .then(convocatorias => {
                tbody.replaceChildren();

                convocatorias.forEach(convocatoria => {
                    var fila = filaC.cloneNode(true);

                    var nombre = fila.querySelector(".nombreConvocatoria");
                    var duracion = fila.querySelector(".duracionConvocatoria");
                    var tipo = fila.querySelector(".tipoConvocatoria");
                    var inicio = fila.querySelector(".inicioSolicitues");
                    var fin = fila.querySelector(".finSolicitudes");
                    var destino = fila.querySelector(".destinoConvocatoria");
                    var btn = fila.querySelector(".btnRealizarSolicitud");

                    nombre.innerHTML = "nombre";
                    duracion.innerHTML = convocatoria.duracion;
                    tipo.innerHTML = convocatoria.tipo;
                    inicio.innerHTML = cambiarFormatoFecha(convocatoria.fechaIniSolicitud);
                    fin.innerHTML = cambiarFormatoFecha(convocatoria.fechaFinSolicitud);
                    destino.innerHTML = convocatoria.destino;
                    
                    
                    btn.onclick = function () {

                    }

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
        let año = partes[0].slice(-2); // Obtiene los últimos dos dígitos del año
        let mes = partes[1];
        let dia = partes[2];
    
        return `${dia}-${mes}-${año}`;
    }
})