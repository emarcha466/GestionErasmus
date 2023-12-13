<script src="./javaScript/realizarSolicitudJS.js"></script>
<script src="./javaScript/webcam.js"></script>
<main id="realizarSolicitud">
    <h2>Realizar Solicitud</h2>
    <p class="error"></p>
    <p class="success"></p>
    <form action="" method="post" id="formSolicitud">
        <label for="dni">DNI:</label><br>
        <input type="text" id="dni" name="dni" data-valida="dni"><br>
        <label for="apellidos">Apellidos:</label><br>
        <input type="text" id="apellidos" name="apellidos" data-valida="relleno"><br>
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" data-valida="relleno"><br>
        <label for="fechaNac">Fecha de Nacimiento:</label><br>
        <input type="date" id="fechaNac" name="fechaNac" data-valida="fecha"><br>
        <label for="curso">Curso:</label><br>
        <select name="curso" id="curso" data-valida="select">
            <option value="-1">Seleccione su curso</option>
        </select><br>
        <label for="telefono">Teléfono:</label><br>
        <input type="tel" id="telefono" name="telefono" data-valida="telefono"><br>
        <label for="correo">Correo:</label><br>
        <input type="email" id="correo" name="correo" data-valida="email"><br>
        <label for="domicilio">Domicilio:</label><br>
        <input type="text" id="domicilio" name="domicilio" data-valida="relleno"><br>
        <label for="pass">Contraseña:</label><br>
        <input type="password" id="pass" name="pass" data-valida="relleno"><br>
        <label for="imagen">Imagen:</label><br>
        <button id="openWebcam" onclick="modalFoto(event)">Abrir Webcam</button><br>
        <img id="imgFotoPerfil" src="" alt="Foto Perfil">
        <input type="text" id="blob" name="imagen" readonly> <br>
        <div id="infoTutor" style="display: none;">
            <label for="dniTutor">DNI Tutor:</label><br>
            <input type="text" id="dniTutor" name="dniTutor"><br>
            <label for="apellidosTutor">Apellidos Tutor:</label><br>
            <input type="text" id="apellidosTutor" name="apellidosTutor"><br>
            <label for="nombreTutor">Nombre Tutor:</label><br>
            <input type="text" id="nombreTutor" name="nombreTutor"><br>
            <label for="telefonoTutor">Teléfono Tutor:</label><br>
            <input type="tel" id="telefonoTutor" name="telefonoTutor"><br>
            <label for="domicilioTutor">Domicilio Tutor:</label><br>
            <input type="text" id="domicilioTutor" name="domicilioTutor"><br>
        </div id="infoTutor">
        <input type="button" value="Realizar solicitud" id="btnSolicitud" class="btnPantalla">
    </form>

</main>