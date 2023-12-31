<script src="./javaScript/estadoSolicitudJS.js"></script>
<?php
$valida = new Validacion();
if (isset($_POST['consultaEstado'])) {
    $valida->Requerido('solicitud');
    $valida->Requerido('dni');
    $valida->Requerido('contrasena');
    //Comprobamos validacion
    if ($valida->ValidacionPasada()) {
        if (SolicitudRepo::solicitarSolicitud($_POST['solicitud'], $_POST['dni'], $_POST['contrasena'])) {
            //var_dump("hecho");
        } else {
            $_SESSION['login_error'] = true;
        }
    } else {
        $_SESSION['campos_vacios'] = true;
    }
}
?>

<main id="estadoSolicitudLogin">
    <h2>Consultar estado de la Solicitud</h2>
    <p class="success" style="display: none;"></p>
    <p class="error" style="display: none;"></p>
    <?php
    if (isset($_SESSION['login_error']) && $_SESSION['login_error']) {
        echo ("<p class='error'>Los datos introducidos no corresponden con una solicitud</p>");
        unset($_SESSION['login_error']);
    } elseif (isset($_SESSION['campos_vacios']) && $_SESSION['campos_vacios']) {
        echo ("<p class='error'>Debe rellenar todos los campos</p>");
        unset($_SESSION['campos_vacios']);
    }
    ?>
    <form action="" method="post">
        <label for="convocatoria">ID Solicitud:</label>
        <input type="text" name="solicitud" id="solicitud" data-valida="relleno">
        <label for="dni">DNI:</label>
        <input type="text" name="dni" id="dni" data-valida="dni">
        <label for="contrasena">Contraseña:</label>
        <input type="text" name="contrasena" id="contrasena" data-valida="relleno">
        <input type="submit" value="Consultar estado" name="consultaEstado" class="btnPantalla" id="btnConsultar">
    </form>
</main>