<?php
//si el formualario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['accion']) {
        case "Crear Convocatoria":
            //todo recoger los datos del formulario y crear la convocatoria
            break;
        case "Actualizar convocatoria":
            //todo recoger los datos del formulario y actualizar la convocatoria
            break;
    }
}
?>
<script src="./javaScript/formularioConvocatoriaJs.js"></script>
<main id="formularioConvocatoria">
    <h2>Manteniminento de Convocatorias</h2>
    <form action="" name="crearConvocatoria">
        <div id="datosGeneralesConvo">
            <label for="proyecto">Proyecto:</label>
            <select name="proyecto" id="proyecto"></select>
            <label for="id" hidden>ID:</label>
            <input type="text" name="id" disabled hidden>
            <label for="num_movilidades">Número de Movilidades:</label>
            <input type="number" name="num_movilidades" id="num_movilidades" min="6" value="6">
            <label for="duracion">Duración:</label>
            <input type="number" name="duracion" id="duracion" min="15" value="60">
            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo">
                <option value="corta duracion">Corta Duración</option>
                <option value="larga duracion">Larga Duración</option>
            </select>
            <label for="fechaIniSolicitud">Fecha Inicio de Solicitud:</label>
            <input type="date" name="fechaIniSolicitud">
            <label for="fechaFinSolicitud">Fecha Fin de Solicitud:</label>
            <input type="date" name="fechaFinSolicitud">
            <label for="fechaIniPruebas">Fecha Inicio de Pruebas:</label>
            <input type="date" name="fechaIniPruebas">
            <label for="fechaFinPruebas">Fecha Fin de Pruebas:</label>
            <input type="date" name="fechaFinPruebas">
            <label for="fechaListadoProvisional">Fecha de Listado Provisional:</label>
            <input type="date" name="fechaListadoProvisional">
            <label for="fechaListadoDefinitivo">Fecha de Listado Definitivo:</label>
            <input type="date" name="fechaListadoDefinitivo">
            <label for="destino">Destino:</label>
            <input type="text" name="destino">

        </div>
        <div id="destinatariosConvo">
            <label for="destinatarios">Destinatarios:</label>

        </div>
        <div id="itemBaremablesConvo">
            <label for="itemBaremables">Items Baremables:</label>
            <table>
                <thead>
                    <tr>
                        <th>Seleccionado</th>
                        <th>Nombre</th>
                        <th>Nota</th>
                        <th>Requisito</th>
                        <th>Valor Mínimo</th>
                        <th>Aporta Alumno</th>
                    </tr>
                </thead>
                <tbody id="tbItemBaremables"></tbody>
            </table>
            <?php
            if (isset($_SESSION['convocatoria']['accion']) && $_SESSION['convocatoria']['accion'] == "crear") {
                echo ('<input type="submit" value="Crear Convocatoria" name="accion" class="btnPantalla">');
            } elseif (isset($_SESSION['convocatoria']['accion']) && $_SESSION['convocatoria']['accion'] == "actualizar") {
                echo ('<input type="submit" value="Actualizar Convocatoria" name="accion" class="btnPantalla">');
            }
            ?>
        </div>

    </form>
</main>