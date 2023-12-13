let r;

window.addEventListener("load", function () {
    const contenedor = this.document.getElementById("contenedor");
    const boton = document.getElementById("openWebcam");
    //document.getElementById('blob').style.display="none";
});

function modalFoto(ev) {
    ev.preventDefault();
    var video = document.createElement("video");
    var contenedor = document.createElement("div");
    var canvas = document.createElement("canvas");
    var cuadrito = document.createElement("div");
    var btnCaptura = document.createElement("button");
    var btnEnviarFoto = document.createElement("button");

    video.setAttribute("id", "player");
    video.controls = true;
    video.style.width = "100%";
    video.style.height = "auto";
    video.autoplay = true;

    contenedor.setAttribute("id", "contenedor");
    canvas.setAttribute("id", "canvas");

    canvas.style.width = video.clientWidth + "px";
    canvas.style.height = video.clientHeight + "px";
    cuadrito.setAttribute("id", "cuadrito");

    const context = canvas.getContext('2d');

    btnCaptura.innerHTML = "Tomar Foto";
    btnCaptura.setAttribute("id", "capture");
    btnCaptura.style.margin = "10%";

    btnEnviarFoto.innerHTML = "Finalizar";
    btnEnviarFoto.setAttribute("id", "btnFinalizarFoto");
    btnEnviarFoto.style.margin = "10%";
    cuadrito.style.display = "none";

    btnEnviarFoto.addEventListener("click", function (event) {
        event.preventDefault();
        document.getElementById('imgFotoPerfil').src = r.recortar();
        document.getElementById('blob').value = r.recortar();
        document.getElementById('blob').setAttribute("readonly", "readonly");
        cerrarModal(event);
    });
    const constraints = {
        video: true,
    };

    btnCaptura.addEventListener('click', () => {
        // Draw the video frame to the canvas.
        canvas.width = video.clientWidth;
        canvas.height = video.clientHeight;
        canvas.style.width = canvas.width + "px";
        canvas.style.height = canvas.height + "px";
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        r = new Recuadro(0, 0, 100, 200, canvas);
        r.pinta();
        //CONSEGUIR BASE64 const imageDataURL = canvas.toDataURL('image/png');

    });

    // Attach the video stream to the video element and autoplay.
    navigator.mediaDevices.getUserMedia(constraints).then((stream) => {
        video.srcObject = stream;
    });

    var modal = document.createElement("div");
    modal.style.position = "fixed";
    modal.style.left = 0;
    modal.style.top = 0;
    modal.style.width = "100%";
    modal.style.height = "100%";
    modal.style.backgroundColor = "rgba(0,0,0,0.5)";
    modal.style.zIndex = 99;
    modal.setAttribute("id", "modal");
    document.body.appendChild(modal);

    var visualizador = document.createElement("div");
    visualizador.style.position = "fixed";
    visualizador.style.left = "15%";
    visualizador.style.top = "15%";
    visualizador.style.width = "70%";
    visualizador.style.height = "70%";
    visualizador.style.display = "grid";
    visualizador.style.gridTemplateColumns = "50% 50%";
    visualizador.style.gridTemplateRows = "70% 30%";
    visualizador.style.backgroundColor = "white";
    visualizador.style.zIndex = 100;
    visualizador.setAttribute("id", "visualizador");
    visualizador.appendChild(video);
    visualizador.appendChild(canvas);
    visualizador.appendChild(cuadrito);
    visualizador.appendChild(btnCaptura);
    visualizador.appendChild(btnEnviarFoto);
    document.body.appendChild(visualizador);


    var closer = document.createElement("div");
    closer.innerHTML = "X";
    closer.style.position = "fixed";
    closer.style.padding = "5px";
    closer.style.backgroundColor = "white";
    closer.style.top = 0;
    closer.style.right = 0;
    closer.style.zIndex = 101;
    closer.setAttribute("id", "closer");
    document.body.appendChild(closer);

    closer.setAttribute("onclick", "cerrarModal(event)");

}

function cerrarModal(ev) {
    ev.preventDefault();
    document.body.removeChild(document.getElementById("modal"));
    document.body.removeChild(document.getElementById("visualizador"));
    document.body.removeChild(document.getElementById("closer"));
}

//y coordenada y del extremo superior del recuadro en pixels
//ancho ancho en pixels
//alto alto en pixels

function Recuadro(x, y, ancho, alto, imagen) {
    this.x = x;
    this.y = y;
    this.ancho = ancho;
    this.alto = alto;
    this.imagen = imagen;
    this.contenedor = null;
    this.dom = null;
    this.mouseX = 0;
    this.mouseY = 0;
}


Recuadro.prototype.pinta = function (color = "black") {
    //Creo el div y configuro su estilo
    var rec = document.createElement("div");
    rec.style.position = "absolute";
    rec.style.top = this.x + "px";
    rec.style.left = this.y + "px";
    rec.style.width = this.ancho + "px";
    rec.style.height = this.alto + "px";
    rec.style.border = "1px solid " + color;
    rec.style.zIndex = 99;
    //Programo el movimiento del cuadradito
    rec.addEventListener("mousedown", pulsadoRaton(this))
    rec.addEventListener("mousemove", moverRaton(this))
    rec.addEventListener("mouseup", soltarRaton(this))

    this.dom = rec;
    //Creo un contenedor para la imagen donde aÃ±adir el div creado encima;
    var contenedor = document.createElement("div");
    contenedor.style.position = "relative";
    contenedor.style.display = "inline-block"
    this.contenedor = contenedor;
    //Lo introduzco justo delante de la imagen, introduciendo la imagen dentro 
    //y el cuadradito.
    this.imagen.parentNode.insertBefore(contenedor, this.imagen);
    contenedor.appendChild(this.imagen);
    contenedor.appendChild(rec);

    function pulsadoRaton(objeto) {
        return function (ev) {
            //Si he pulsado el botÃ³n izquierdo muevo el cuadradito
            if (ev.buttons > 0 && ev.button == 0) {
                objeto.mouseX = ev.offsetX;
                objeto.mouseY = ev.offsetY;
            }
        }
    }
    function moverRaton(objeto) {
        return function (ev) {
            //Si he pulsado el botÃ³n izquierdo muevo el cuadradito
            if (ev.buttons > 0 && ev.button == 0) {
                objeto.dom.style.left = parseInt(objeto.dom.style.left) + (ev.offsetX - objeto.mouseX) + "px";
                objeto.dom.style.top = parseInt(objeto.dom.style.top) + (ev.offsetY - objeto.mouseY) + "px";
            }
        }
    }

    function soltarRaton(objeto) {
        return function (ev) {
            //Si he pulsado el botÃ³n izquierdo muevo el cuadradito
            //Borro el auxiliar del movimiento
            objeto.mouseX = 0;
            objeto.mouseY = 0;
            objeto.x = parseInt(objeto.dom.style.left);
            objeto.y = parseInt(objeto.dom.style.top);
        }
    }
}

Recuadro.prototype.recortar = function () {
    var c = document.createElement("canvas");
    var img = document.createElement("img");
    //defino el tamaÃ±o del canvas y la imagen
    c.width = this.ancho;
    c.height = this.alto;
    img.width = this.ancho;
    img.height = this.alto;
    var ctx = c.getContext("2d");
    ctx.drawImage(this.imagen, this.x, this.y, this.ancho, this.alto, 0, 0, this.ancho, this.alto);
    img.src = c.toDataURL();
    return img.src;
}