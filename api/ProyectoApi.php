<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recojo las variables para hacer el insert
    $codigoProyecto = $_POST['codigoProyecto'];
    $nombreProyecto = $_POST['nombreProyecto'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];

    $proyecto = new Proyecto($codigoProyecto, $nombreProyecto, $fechaInicio, $fechaFin);

    $row = ProyectoRepo::setProyecto($proyecto);
    if ($row > 0) {
        http_response_code(200);
        echo (json_encode(["status" => "success", "message" => "Proyecto añadido correctamente"]));
    } else {
        http_response_code(418);
        echo (json_encode(["status" => "error", "message" => "No se ha podido añadir el proyecto"]));
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['codigoProyecto'])) {
        $proyecto = ProyectoRepo::getProyectoByCodigo($_GET['codigoProyecto']);
        $proyectoJson = json_encode($proyecto);
        echo ($proyectoJson);
    } else {
        $proyectos = ProyectoRepo::getProyectos();
        $proyectosJson = json_encode($proyectos);
        echo ($proyectosJson);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['codigoProyecto'])) {

        $codigo = $_GET['codigoProyecto'];
        $row = ProyectoRepo::deleteProyectoByCodigo($codigo);
        header('Content-Type: application/json');

        if ($row > 0) {
            http_response_code(200);
            echo (json_encode(["status" => "success", "message" => "Proyecto eliminado correctamente"]));
        } else {
            http_response_code(418);
            echo (json_encode(["status" => "error", "message" => "No se ha podido eliminar el proyecto"]));
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
}
