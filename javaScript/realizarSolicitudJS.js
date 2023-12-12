window.addEventListener('load', function () {
    let idConvo = this.localStorage.getItem("idConvo")
    let fechaNac = this.document.getElementById("fechaNac")
    let btnSolicitud = this.document.getElementById("btnSolicitud")
    let formSolicitud = this.document.getElementById("formSolicitud")


    fechaNac.addEventListener('change', function () {
        var fechaNacimiento = new Date(this.value);
        if (esMayorDeEdad(fechaNacimiento)) {
            document.getElementById('infoTutor').style.display = 'none';
        } else {
            document.getElementById('infoTutor').style.display = '';
        }
    })

    btnSolicitud.addEventListener('click',function(ev){
        let formData = new FormData(formSolicitud);
        formData.append("idConvocatoria",idConvo)
        for (var pair of formData.entries()) {
            console.log(pair[0]+ ', '+ pair[1]); 
        }
        fetch("./api/SolicitudApi.php",{
            method: 'POST',
            body: formData
        })
        .then(x=>x.json())
        .then(respuesta=>{
            if(respuesta.status =="success"){
                console.log(respuesta.message +" "+respuesta.id);
                //uso encodeURIComponent para evitar que pueda cambiar el valor al pasarlo por url
                fetch("./api/BaremacionApi.php?idConvocatoria="+encodeURIComponent(idConvo)+"&idSolicitud="+encodeURIComponent(respuesta.id),{
                    method: 'POST'
                })
                .then(x=>x.json())
                .then(response =>{
                    console.log(response)
                })



            }else{
                console.log(respuesta.message)
            }
        })
    })

    /**
     * Funcion que devuelve si una fecha es mayor de edad
     * 
     * @param {*} fechaNac Fecha de nacimiento
     * @returns true si es mayor, false si es menor
     */
    function esMayorDeEdad(fechaNac) {
        var hoy = new Date();
        var edad = hoy.getFullYear() - fechaNac.getFullYear();
        var m = hoy.getMonth() - fechaNac.getMonth();
        if (m < 0 || (m === 0 && hoy.getDate() < fechaNac.getDate())) {
            edad--;
        }
        return edad >= 18;
    }
})