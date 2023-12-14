window.addEventListener('load', function () {
    let idConvo = this.localStorage.getItem("idConvo")
    let fechaNac = this.document.getElementById("fechaNac")
    let btnSolicitud = this.document.getElementById("btnSolicitud")
    let formSolicitud = this.document.getElementById("formSolicitud")


    //rellenar los cursos con los destinatarios de la convocatoria
    this.fetch("./api/ConvocatoriaDestinatarioApi.php?idConvocatoria=" + encodeURIComponent(idConvo), {
        method: 'GET'
    })
        .then(x => x.json())
        .then(dest => {
            if (dest) {
                dest.forEach(element => {
                    let option = this.document.createElement("option")
                    let select = this.document.getElementById("curso")
                    option.value = element.codigoGrupo
                    option.innerHTML = element.codigoGrupo
                    select.appendChild(option)
                });

            }
        })

    //muestra los datos de tutor si es menor
    fechaNac.addEventListener('change', function () {
        var fechaNacimiento = new Date(this.value);
        let inputsTutor = Array.from(document.getElementById("infoTutor").children);

        //si es menor de edad los datos de tutor tambien son requeridos
        if (esMayorDeEdad(fechaNacimiento)) {
            document.getElementById('infoTutor').style.display = 'none';
            inputsTutor.forEach(input => {
                input.removeAttribute('data-valida');
            })
        } else {
            document.getElementById('infoTutor').style.display = '';
            inputsTutor.forEach(input => {
                input.setAttribute('data-valida', 'relleno');
            })
        }
    })

    btnSolicitud.addEventListener('click', function (ev) {
        ev.preventDefault()
        if (this.form.valida()) {
            let formData = new FormData(formSolicitud);
            formData.append("idConvocatoria", idConvo)

            //llamada a la api para crear la solicitud
            fetch("./api/SolicitudApi.php", {
                method: 'POST',
                body: formData
            })
                .then(x => x.json())
                .then(respuesta => {
                    if (respuesta.status == "success") {
                        console.log(respuesta.message + " " + respuesta.id);
                        //uso encodeURIComponent para evitar que pueda cambiar el valor al pasarlo por url

                        //si se ha creado la solicitud correctamente, añado los itemBaremables a la baremacion
                        fetch("./api/BaremacionApi.php?idConvocatoria=" + encodeURIComponent(idConvo) + "&idSolicitud=" + encodeURIComponent(respuesta.id), {
                            method: 'POST'
                        })
                            .then(x => x.json())
                            .then(response => {
                                //si se ha creado correctamente, mando los datos de consulta de la solicitud al correo proporcionado
                                if (response.status == "success") {

                                    //relleno la plantilla del correo
                                    fetch('./views/plantillasCorreo/datosSolicitud.html')
                                        .then(x => x.text())
                                        .then(plantilla => {
                                            let html = plantilla.replace('{dni}', formData.get("dni"))
                                                .replace('{idSolicitud}', respuesta.id)
                                                .replace('{pass}', formData.get("pass"));

                                            let datos = new FormData();
                                            datos.append('cuerpo', html);
                                            datos.append('destinatario', formData.get("correo"))
                                            datos.append('asunto', "Localizador  de solicitud")

                                            fetch('./api/CorreoApi.php', {
                                                method: 'POST',
                                                body: datos
                                            })
                                                .then(x => x.json())
                                                .then(respC => {
                                                    if (respC.status == "success") {
                                                        formSolicitud.reset()
                                                        muestraCorrecto("Solicitud enviada correctamente")
                                                        //borro el id de la convocatoria del localstorage
                                                        localStorage.removeItem("idConvo")
                                                        setTimeout(function () {
                                                            location.href = "?menu=estadoSolicitudLogin"
                                                        }, 3000)
                                                    }
                                                })
                                        });
                                }
                            })

                    } else {
                        muestraError(respuesta.message)
                    }
                })
        } else {
            muestraError("Revise los campos del formulario")
        }

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