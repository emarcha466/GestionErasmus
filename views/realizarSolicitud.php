<script src="./javaScript/realizarSolicitudJS.js"></script>
<main id="realizarSolicitud">
    <h2>Realizar Solicitud</h2>
    <form action="" method="post" id="formSolicitud">
        <label for="dni">DNI:</label><br>
        <input type="text" id="dni" name="dni"><br>
        <label for="apellidos">Apellidos:</label><br>
        <input type="text" id="apellidos" name="apellidos"><br>
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre"><br>
        <label for="fechaNac">Fecha de Nacimiento:</label><br>
        <input type="date" id="fechaNac" name="fechaNac"><br>
        <label for="curso">Curso:</label><br>
        <input type="text" id="curso" name="curso"><br>
        <label for="telefono">Teléfono:</label><br>
        <input type="tel" id="telefono" name="telefono"><br>
        <label for="correo">Correo:</label><br>
        <input type="email" id="correo" name="correo"><br>
        <label for="domicilio">Domicilio:</label><br>
        <input type="text" id="domicilio" name="domicilio"><br>
        <label for="pass">Contraseña:</label><br>
        <input type="password" id="pass" name="pass"><br>
        <label for="imagen">Imagen:</label><br>
        <input type="file" id="imagen" name="imagen"><br>
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
        <input type="button" value="Realizar solicitud" id="btnSolicitud">
    </form>

</main>