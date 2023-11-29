<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recojo las variables para hacer el insert
    $id = $_POST['id'];
    $num_movilidades = $_POST['num_movilidades'];
    $duracion = $_POST['duracion'];
    $tipo = $_POST['tipo'];
    $fechaIniSolicitud = $_POST['fechaIniSolicitud'];
    $fechaFinSolicitud = $_POST['fechaFinSolicitud'];
    $fechaIniPruebas = $_POST['fechaIniPruebas'];
    $fechaFinPruebas = $_POST['fechaFinPruebas'];
    $fechaListadoProvisional = $_POST['fechaListadoProvisional'];
    $fechaListadoDefinitivo = $_POST['fechaListadoDefinitivo'];
    $codigoProyecto = $_POST['codigoProyecto'];
    $destino = $_POST['destino'];

    $convocatoria = new Convocatoria($id, $num_movilidades, $duracion, $tipo, $fechaIniSolicitud, $fechaFinSolicitud, $fechaIniPruebas, $fechaFinPruebas, $fechaListadoProvisional, $fechaListadoDefinitivo, $codigoProyecto, $destino);

    $row = ConvocatoriaRepo::setConvocatoria($convocatoria);
    if ($row > 0) {
        http_response_code(200);
        echo (json_encode(["status" => "success", "message" => "Convocatoria añadida correctamente"]));
    } else {
        http_response_code(418);
        echo (json_encode(["status" => "error", "message" => "No se ha podido añadir la convocatoria"]));
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $convocatoria = ConvocatoriaRepo::getConvocatoriaById($id);
        $convocatoriaJson = json_encode($convocatoria);
        echo ($convocatoriaJson);
    } elseif (isset($_GET['date'])) {
        $date = $_GET['date'];
        $convocatorias = ConvocatoriaRepo::getConvocatoriasEnPeriodoSolicitud($date);
        $convocatoriasJson = json_encode($convocatorias);
        echo ($convocatoriasJson);
    } else {
        $convocatorias = ConvocatoriaRepo::getConvocatorias();
        $convocatoriasJson = json_encode($convocatorias);
        echo ($convocatoriasJson);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $row = ConvocatoriaRepo::deleteConvocatoriaById($id);

        header('Content-Type: application/json');

        if ($row > 0) {
            http_response_code(200);
            echo (json_encode(["status" => "success", "message" => "Convocatoria eliminada correctamente"]));
        } else {
            http_response_code(418);
            echo (json_encode(["status" => "error", "message" => "No se ha podido eliminar la convocatoria"]));
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    //TODO Añadir que se pueda actualizar una convocatoria
}
