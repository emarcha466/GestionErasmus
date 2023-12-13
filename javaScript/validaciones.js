HTMLInputElement.prototype.relleno = function () {
    var respuesta = false;
    if (this.value != "") {
        respuesta = true;
    }
    return respuesta;
}

HTMLInputElement.prototype.dni = function () {
    var respuesta = false;
    if (this.value != "") {
        const letras = 'TRWAGMYFPDXBNJZSQVHLCKE';

        var partes = (/^(\d{8})([TRWAGMYFPDXBNJZSQVHLCKE])$/i).exec(this.value);
        if (partes) {
            respuesta = (letras[partes[1] % 23] === partes[2].toUpperCase());
        }
    }
    return respuesta;
}

HTMLInputElement.prototype.edad = function () {
    var respuesta = false;
    if (this.value == parseInt(this.value) && this.value >= 0 && this.value < 150) {
        respuesta = true;
    }
    return respuesta;
}
HTMLInputElement.prototype.seleccionado = function () {
    var respuesta = false;
    var name = this.name;
    if (this.form[name].value != "") {
        respuesta = true;
    }
    return respuesta;
}

HTMLInputElement.prototype.email = function () {
    var respuesta = false;
    if (this.value != "") {
        var partes = (/^([\w\.\-_]+)?\w+@[\w-_]+(\.\w+){1,}$/).exec(this.value);
        if (partes) {
            respuesta = true;
        }
    }
    return respuesta;
}

HTMLInputElement.prototype.telefono = function () {
    var respuesta = false;
    if (this.value != "") {
        var partes = (/^[679]\d{8}$/).exec(this.value);
        if (partes) {
            respuesta = true;
        }
    }
    return respuesta;
}

HTMLInputElement.prototype.fecha = function () {
    var respuesta = false;
    if (this.value != "") {
        //fechas americanas por eso pongo el año al principio
        var partes = (/^(\d{4})-(\d{2})-(\d{2})$/).exec(this.value);
        if (partes) {
            respuesta = true;
        }
    }
    return respuesta;
}

HTMLInputElement.prototype.numero = function () {
    var respuesta = false;
    if (this.value != "") {
        var partes = (/^(\d+)$/).exec(this.value);
        if (partes && parseInt(partes[1]) > 0) {
            respuesta = true;
        }
    }
    return respuesta;
}

HTMLInputElement.prototype.pdfSeleccionado = function () {
    var respuesta = false;
    if (this.files.length > 0) {
        var fileName = this.files[0].name;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substring(idxDot).toLowerCase();
        if (extFile == "pdf") {
            respuesta = true;
        }
    }
    return respuesta;
}

HTMLFieldSetElement.prototype.valida = function () {
    // Buscar todos los checkboxes en el fieldset
    var checkboxes = this.querySelectorAll('input[type="checkbox"]');

    // Verificar si al menos uno está marcado
    for (let i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            // Si al menos uno está marcado, la validación es exitosa
            return true;
        }
    }

    // Si ninguno está marcado, la validación falla
    return false;
}

HTMLSelectElement.prototype.select=function(){
    var respuesta = false
    var name = this.name
    if(this.form[name].value!="-1"){
        respuesta = true
    }
    return respuesta
}

HTMLFormElement.prototype.valida = function () {
    var elementos = this.querySelectorAll("input[data-valida]:not(td.disabled > *),select[data-valida],fieldset[data-valida]");
    var respuesta = true;
    let n = elementos.length;
    for (let i = 0; i < n; i++) {

        if (elementos[i].offsetParent === null) continue;

        let tipo = elementos[i].getAttribute("data-valida");
        var aux = elementos[i][tipo]();
        if (aux) {
            //elementos[i].classList.add("valido");
            elementos[i].classList.remove("invalido");

            // Remover la clase 'valido' después de 2 segundos
            // setTimeout(function () {
            //     elementos[i].classList.remove("valido");
            // }, 2000);
        } else {
            //elementos[i].classList.remove("valido");
            elementos[i].classList.add("invalido");

            // Remover la clase 'invalido' después de 2 segundos
            // setTimeout(function () {
            //     elementos[i].classList.remove("invalido");
            // }, 2000);
        }
        respuesta = respuesta && aux;
    }
    return respuesta;
}