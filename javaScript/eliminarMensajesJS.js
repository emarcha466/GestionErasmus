window.addEventListener("load", function(){
    let mensajes = this.document.querySelectorAll(".error, .success")

    //funcion que elimina los mensajes del formulario
    mensajes.forEach(mensaje=>{
        setTimeout(function() {
            mensaje.style.display="none"
        }, 3000);
    })
})