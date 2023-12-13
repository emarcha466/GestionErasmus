/**
     * Función que muestra un mensaje de error en una etiqueta de clase error
     * Necesario tener una etiqueta con la clase error
     */
function muestraError(mensaje) {
    error = document.getElementsByClassName("error")[0];
    error.innerHTML = mensaje;
    error.style.display = "";
    setTimeout(function () {
        error.style.display = "none";
    }, 3000);
}

/**
 * Función que muestra un mensaje cuando ocurre lo correcto, en una etiqueta de clase success
 * Necesario tener una etiqueta con la clase success
 */
function muestraCorrecto(mensaje) {
    success = document.getElementsByClassName("success")[0];
    success.innerHTML = mensaje;
    success.style.display = "";
    setTimeout(function () {
        success.style.display = "none";
    }, 3000);
}