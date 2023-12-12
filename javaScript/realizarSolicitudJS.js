window.addEventListener('load', function () {
    let idConvo = this.localStorage.getItem("idConvo")
    let fechaNac = this.document.getElementById("fechaNac")

    fechaNac.addEventListener('change', function () {
        var fechaNacimiento = new Date(this.value);
        if (esMayorDeEdad(fechaNacimiento)) {
            document.getElementById('infoTutor').style.display = 'none';
        } else {
            document.getElementById('infoTutor').style.display = '';
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