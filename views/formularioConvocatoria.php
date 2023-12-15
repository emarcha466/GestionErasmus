<?php
//si el formualario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //$valida = true;
    $valida=new Validacion();

    $valida->diferciaFechas('fechaIniSolicitud', 'fechaFinSolicitud');
    $valida->diferciaFechas('fechaFinSolicitud', 'fechaIniPruebas');
    $valida->diferciaFechas('fechaIniPruebas', 'fechaFinPruebas');
    $valida->diferciaFechas('fechaFinPruebas', 'fechaListadoProvisional');
    $valida->diferciaFechas('fechaListadoProvisional', 'fechaListadoDefinitivo');
    $valida->Requerido('destino');
    $valida->validarCheckbox('destinatario');
    $valida->validarCheckbox('itemBaremable');

    $correcto = true;
    if ($valida->ValidacionPasada()) {
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

                    if (isset($_POST['idNivelIdioma']) && isset($_POST['notaIdioma'])) {
                        $idNivelIdiomas = $_POST['idNivelIdioma'];
                        $notasIdioma = $_POST['notaIdioma'];

                        // Asegúrate de que ambos arrays tienen la misma longitud
                        if (count($idNivelIdiomas) == count($notasIdioma)) {
                            $convocatoriaBaremoIdiomas = array();

                            for ($i = 0; $i < count($idNivelIdiomas); $i++) {
                                // Crea un nuevo objeto ConvocatoriaBaremoIdioma y añádelo al array
                                $convocatoriaBaremoIdiomas[] = new ConvocatoriaBaremoIdioma($idNivelIdiomas[$i], $idConvocatoria, $notasIdioma[$i]);
                            }

                            // Llama a la función para insertar los datos en la base de datos
                            $rows = ConvocatoriaBaremoIdiomaRepo::setConvocatoriaBaremoIdioma($convocatoriaBaremoIdiomas);
                        } else {
                            $correcto = false;
                        }
                    } else {
                        echo "No se proporcionaron idNivelIdioma y/o notaIdioma.";
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
    }else{
        $_SESSION['noValida'] = true;
    }
}
?>
<script src="./javaScript/formularioConvocatoriaJs.js"></script>
<main id="formularioConvocatoria">
    <h2>Manteniminento de Convocatorias</h2>
    <?php
            if(isset($_SESSION['noValida']) && $_SESSION['noValida']) {
                echo("<p class='error'>Revise los campos del formulario</p>");
                unset($_SESSION['noValida']);
            }
            ?>
    <form method="post" action="" name="crearConvocatoria">

        <div id="datosGeneralesConvo">
            <label for="proyecto">Proyecto:</label>
            <select name="proyecto" id="proyecto"></select>
            <input type="text" name="id" value="<?php echo isset($_SESSION['convocatoria']) ? $_SESSION['convocatoria']->getId() : ''; ?>" disabled hidden>
            <label for="num_movilidades">Número de Movilidades:</label>
            <input type="number" name="num_movilidades" id="num_movilidades" min="6" value="<?php echo isset($_SESSION['convocatoria']) ? $_SESSION['convocatoria']->getNumMovilidades() : '6'; ?>">
            <label for="duracion">Duración:</label>
            <input type="number" name="duracion" id="duracion" min="15" value="<?php echo isset($_SESSION['convocatoria']) ? $_SESSION['convocatoria']->getDuracion() : '60'; ?>">
            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo">
                <option value="corta duracion" <?php echo isset($_SESSION['convocatoria']) && $_SESSION['convocatoria']->getTipo() == 'corta duracion' ? 'selected' : ''; ?>>Corta Duración</option>
                <option value="larga duracion" <?php echo isset($_SESSION['convocatoria']) && $_SESSION['convocatoria']->getTipo() == 'larga duracion' ? 'selected' : ''; ?>>Larga Duración</option>
            </select>
            <label for="fechaIniSolicitud">Fecha Inicio de Solicitud:</label>
            <input type="date" name="fechaIniSolicitud" id="fechaIniSolicitud" value="<?php echo isset($_SESSION['convocatoria']) ? $_SESSION['convocatoria']->getFechaIniSolicitud() : ''; ?>">
            <label for="fechaFinSolicitud">Fecha Fin de Solicitud:</label>
            <input type="date" name="fechaFinSolicitud" id="fechaFinSolicitud" value="<?php echo isset($_SESSION['convocatoria']) ? $_SESSION['convocatoria']->getFechaFinSolicitud() : ''; ?>">
            <label for="fechaIniPruebas">Fecha Inicio de Pruebas:</label>
            <input type="date" name="fechaIniPruebas" id="fechaIniPruebas" value="<?php echo isset($_SESSION['convocatoria']) ? $_SESSION['convocatoria']->getFechaIniPruebas() : ''; ?>">
            <label for="fechaFinPruebas">Fecha Fin de Pruebas:</label>
            <input type="date" name="fechaFinPruebas" id="fechaFinPruebas" value="<?php echo isset($_SESSION['convocatoria']) ? $_SESSION['convocatoria']->getFechaFinPruebas() : ''; ?>">
            <label for="fechaListadoProvisional">Fecha de Listado Provisional:</label>
            <input type="date" name="fechaListadoProvisional" id="fechaListadoProvisional" value="<?php echo isset($_SESSION['convocatoria']) ? $_SESSION['convocatoria']->getFechaListadoProvisional() : ''; ?>">
            <label for="fechaListadoDefinitivo">Fecha de Listado Definitivo:</label>
            <input type="date" name="fechaListadoDefinitivo" id="fechaListadoDefinitivo" value="<?php echo isset($_SESSION['convocatoria']) ? $_SESSION['convocatoria']->getFechaListadoDefinitivo() : ''; ?>">
            <label for="destino">Destino:</label>
            <input type="text" name="destino" id="destino" value="<?php echo isset($_SESSION['convocatoria']) ? $_SESSION['convocatoria']->getDestino() : ''; ?>">

        </div>
        <div id="destinatariosConvo">
            <label for="destinatarios">Destinatarios:</label>

        </div>
        <div id="itemBaremablesConvo">
            <label for="itemBaremables">Items Baremables:</label>
            <table id="tableItemBaremable">
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
            <div id="puntuacionIdioma" style="display: none;">
                <label for="puntosIdioma">Puntuación nivel ididoma</label>
                <table id="puntosIdioma">
                    <thead>
                        <tr>
                            <th hidden>id</th>
                            <th>Nivel</th>
                            <th>Puntucación</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyPuntosIdioma"></tbody>
                </table>
            </div>
            <?php
            if (isset($_SESSION['accion']) && $_SESSION['accion'] == "crear") {
                echo ('<input type="submit" value="Crear Convocatoria" name="accion" class="btnPantalla">');
            } elseif (isset($_SESSION['accion']) && $_SESSION['accion'] == "actualizar") {
                echo ('<input type="submit" value="Actualizar Convocatoria" name="accion" class="btnPantalla">');
            }
            ?>
        </div>

    </form>
</main>