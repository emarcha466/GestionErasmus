<script src="./javaScript/realizarSolicitudJS.js"></script>
<script src="./javaScript/webcam.js"></script>
<main id="realizarSolicitud">
    <h2>Realizar Solicitud</h2>
    <p class="error"></p>
    <p class="success"></p>
    <form action="" method="post" id="formSolicitud">
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" data-valida="dni">
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" data-valida="relleno">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" data-valida="relleno">
        <label for="fechaNac">Fecha de Nacimiento:</label>
        <input type="date" id="fechaNac" name="fechaNac" data-valida="fecha">
        <label for="curso">Curso:</label>
        <select name="curso" id="curso" data-valida="select">
            <option value="-1">Seleccione su curso</option>
        </select>
        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" data-valida="telefono">
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" data-valida="email">
        <label for="domicilio">Domicilio:</label>
        <input type="text" id="domicilio" name="domicilio" data-valida="relleno">
        <label for="pass">Contraseña:</label>
        <input type="password" id="pass" name="pass" data-valida="relleno">
        <label for="imagen">Imagen:</label>
        <button id="openWebcam" onclick="modalFoto(event)" class="btnRealizarSolicitud">Abrir Webcam</button>
        <img id="imgFotoPerfil" src="" alt="Foto Perfil">
        <input type="hidden" id="blob" name="imagen" readonly>
        <fieldset id="infoTutor" style="display: none;">
            <legend>Tutor legal</legend>
            <label for="dniTutor">DNI Tutor:</label>
            <input type="text" id="dniTutor" name="dniTutor">
            <label for="apellidosTutor">Apellidos Tutor:</label>
            <input type="text" id="apellidosTutor" name="apellidosTutor">
            <label for="nombreTutor">Nombre Tutor:</label>
            <input type="text" id="nombreTutor" name="nombreTutor">
            <label for="telefonoTutor">Teléfono Tutor:</label>
            <input type="tel" id="telefonoTutor" name="telefonoTutor">
            <label for="domicilioTutor">Domicilio Tutor:</label>
            <input type="text" id="domicilioTutor" name="domicilioTutor">
        </fieldset>
        <input type="button" value="Realizar solicitud" id="btnSolicitud" class="btnPantalla">
    </form>

</main>