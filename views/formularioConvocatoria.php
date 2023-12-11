<?php
//si el formualario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correcto = true;
    switch ($_POST['accion']) {
        case "Crear Convocatoria":
            //regojo los datos principales de la convocatoria
            $proyecto = $_POST['proyecto'];
            $num_movilidades = $_POST['num_movilidades'];
            $duracion = $_POST['duracion'];
            $tipo = $_POST['tipo'];
            $fechaIniSolicitud = $_POST['fechaIniSolicitud'];
            $fechaFinSolicitud = $_POST['fechaFinSolicitud'];
            $fechaIniPruebas = $_POST['fechaIniPruebas'];
            $fechaFinPruebas = $_POST['fechaFinPruebas'];
            $fechaListadoProvisional = $_POST['fechaListadoProvisional'];
            $fechaListadoDefinitivo = $_POST['fechaListadoDefinitivo'];
            $destino = $_POST['destino'];

            $convocatoria = new Convocatoria(
                null,
                $num_movilidades,
                $duracion,
                $tipo,
                $fechaIniSolicitud,
                $fechaFinSolicitud,
                $fechaIniPruebas,
                $fechaFinPruebas,
                $fechaListadoProvisional,
                $fechaListadoDefinitivo,
                $proyecto,
                $destino
            );

            $idConvocatoria = ConvocatoriaRepo::setConvocatoria($convocatoria);
            //si se ha creado correctamente la convocatoria (devuelve el id de la convocatorias)
            //creo los itembaremables y los destinatarios
            if ($idConvocatoria > 0) {
                //items baremables
                //compruebo si se ha marcado algun checkbox de los items
                if (isset($_POST['itemBaremable']) && !empty($_POST['itemBaremable'])) {
                    $itemBaremable = $_POST['itemBaremable'];
                    $nombreItem = $_POST['nombreItem'];
                    $nota = $_POST['nota'];
                    $requsitoItem = $_POST['requsitoItem'];
                    $valorMin = $_POST['valorMin'];
                    $aportaAlumnoItem = $_POST['aportaAlumnoItem'];
                    $itemsBaremables = array();

                    for ($i = 0; $i < count($itemBaremable); $i++) {
                        //creo el objeto de la fila con checkbox
                        if (isset($itemBaremable[$i])) {
                            // Crear un nuevo objeto ConvocatoriaItemBaremable con los datos de la fila
                            $item = new ConvocatoriaItemBaremable($idConvocatoria, $itemBaremable[$i], $nota[$i], $requsitoItem[$i], $valorMin[$i], $aportaAlumnoItem[$i]);
                            // Añadir el objeto al array
                            $itemsBaremables[] = $item;
                        }
                    }
                    $rows = ConvocatoriaItemBaremableRepo::setItemsBaremablesParaConvocatoria($idConvocatoria, $itemsBaremables);
                    if ($rows != count($itemsBaremables)) {
                        $correcto = false;
                    }
                } else {
                    //todo mensaje de error
                }

                //destinatarios
                if (!empty($_POST['destinatario'])) {
                    //recojo en un array los id de los destinatarios
                    $idDestinatarios = $_POST['destinatario'];

                    $rows = ConvocatoriaDestinatarioRepo::setDestinatariosParaConvocatoria($idConvocatoria, $idDestinatarios);
                    if ($rows != count($idDestinatarios)) {
                        $correcto = false;
                    }
                }
            }
            if ($correcto) {
                $_SESSION['success'] = "La convocatoria se ha creado correctamente";
                header("Location: ?menu=inicioAdmin");
                exit;
            }

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
    <form method="post" action="" name="crearConvocatoria">
        <div id="datosGeneralesConvo">
            <label for="proyecto">Proyecto:</label>
            <select name="proyecto" id="proyecto"></select>
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
            <input type="date" name="fechaIniSolicitud" id="fechaIniSolicitud">
            <label for="fechaFinSolicitud">Fecha Fin de Solicitud:</label>
            <input type="date" name="fechaFinSolicitud" id="fechaFinSolicitud">
            <label for="fechaIniPruebas">Fecha Inicio de Pruebas:</label>
            <input type="date" name="fechaIniPruebas" id="fechaIniPruebas">
            <label for="fechaFinPruebas">Fecha Fin de Pruebas:</label>
            <input type="date" name="fechaFinPruebas" id="fechaFinPruebas">
            <label for="fechaListadoProvisional">Fecha de Listado Provisional:</label>
            <input type="date" name="fechaListadoProvisional" id="fechaListadoProvisional">
            <label for="fechaListadoDefinitivo">Fecha de Listado Definitivo:</label>
            <input type="date" name="fechaListadoDefinitivo" id="fechaListadoDefinitivo">
            <label for="destino">Destino:</label>
            <input type="text" name="destino" id="destino">

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
            <div id="puntuacionIdioma">
                <label for="puntosIdioma"></label>
                <table id="puntosIdioma">
                    <thead>
                        <tr>
                            <th>Nivel</th>
                            <th>Puntucación</th>
                        </tr>
                    </thead>
                </table>
            </div>
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