<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //recojo las variables para hacer el insert
    $dni = $_POST['dni'];
    $apellidos = $_POST['apellidos'];
    $nombre = $_POST['nombre'];
    $fechaNac = $_POST['fechaNac'];
    $curso = $_POST['curso'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $domicilio = $_POST['domicilio'];
    $pass = $_POST['pass'];
    $idConvocatoria = $_POST['idConvocatoria'];
    $imagen = $_POST['imagen'];
    //$imagen = "ruta";
    $dniTutor = $_POST['dniTutor'];
    $apellidosTutor = $_POST['apellidosTutor'];
    $nombreTutor = $_POST['nombreTutor'];
    $telefonoTutor = $_POST['telefonoTutor'];
    $domicilioTutor = $_POST['domicilioTutor'];

    $solicitud = new Solicitud(
        null,
        $dni,
        $apellidos,
        $nombre,
        $fechaNac,
        $curso,
        $telefono,
        $correo,
        $domicilio,
        $pass,
        $idConvocatoria,
        $imagen,
        $dniTutor,
        $apellidosTutor,
        $nombreTutor,
        $telefonoTutor,
        $domicilioTutor
    );

    $id = SolicitudRepo::setSolicitud($solicitud);
    if ($id > 0) {
        http_response_code(200);
        echo (json_encode(["status" => "success", "message" => "Solicitud añadida correctamente", "id" => $id]));
    } else {
        http_response_code(418);
        echo (json_encode(["status" => "error", "message" => "No se ha podido añadir la solicitud"]));
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id']) && isset($_GET['dni']) && isset($_GET['pass'])) {
        $id = $_GET['id'];
        $dni = $_GET['dni'];
        $pass = $_GET['pass'];
        $solicitud = SolicitudRepo::solicitarSolicitud($id, $dni, $pass);
        $solicitudJson = json_encode($solicitud);
        echo ($solicitudJson);
    } elseif (isset($_GET['id'])) {
        $id = $_GET['id'];
        $solicitud = SolicitudRepo::getSolicitudById($id);
        $solicitudJson = json_encode($solicitud);
        echo ($solicitudJson);
    } else {
        $solicitudes = SolicitudRepo::getSolicitudes();
        $solicitudesJson = json_encode($solicitudes);
        echo ($solicitudesJson);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $row = SolicitudRepo::deleteSolicitudById($id);

        header('Content-Type: application/json');

        if ($row > 0) {
            http_response_code(200);
            echo (json_encode(["status" => "success", "message" => "Solicitud eliminada correctamente"]));
        } else {
            http_response_code(418);
            echo (json_encode(["status" => "error", "message" => "No se ha podido eliminar la solicitud"]));
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    //TODO que la api realice actualizaciones de solicitud
}
