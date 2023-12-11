<?php
$valida = new Validacion();
if (isset($_POST['consultaEstado'])) {
    $valida->Requerido('convocatoria');
    $valida->Requerido('dni');
    $valida->Requerido('contrasena');
    //Comprobamos validacion
    if ($valida->ValidacionPasada()) {
        if (SolicitudRepo::solicitarSolicitud($_POST['convocatoria'], $_POST['dni'], $_POST['contrasena'])) {
            var_dump("hecho");
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
        <label for="convocatoria">Convocatoria:</label>
        <input type="text" name="convocatoria" id="convocatoria">
        <label for="dni">DNI:</label>
        <input type="text" name="dni" id="dni">
        <label for="contrasena">Contraseña:</label>
        <input type="text" name="contrasena" id="contrasena">
        <input type="submit" value="Consultar estado" name="consultaEstado" class="btnPantalla">
    </form>
</main>