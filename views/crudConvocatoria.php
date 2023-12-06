<script src="./javaScript/crudConvocatoriaJs.js"></script>
<main id="crudConvocatoria">
    <form action="" name="crearConvocatoria">
        <label for="proyecto">Proyecto:</label>
        <select name="proyecto" id="proyecto"></select>
        <label for="id" hidden>ID:</label>
        <input type="text" name="id" disabled hidden>
        <label for="num_movilidades">Número de Movilidades:</label>
        <input type="text" name="num_movilidades" id="num_movilidades">
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
        <input type="submit" value="Enviar" class="btnPantalla">
    </form>
</main>