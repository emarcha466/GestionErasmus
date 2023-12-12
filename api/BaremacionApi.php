<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_GET['idConvocatoria']) && isset($_GET['idSolicitud'])) {
        $creado = BaremacionRepo::setItemBaremablesBaremacion($_GET['idConvocatoria'], $_GET['idSolicitud']);
        if ($creado) {
            http_response_code(200);
            echo (json_encode(["status" => "success", "message" => "Items añadidos correctamente"]));
        } else {
            http_response_code(418);
            echo (json_encode(["status" => "error", "message" => "No se ha podido añadir la solicitud"]));
        }
    }else{
        // Recojo las variables para hacer el insert
        $idConvocatoria = $_POST['idConvocatoria'];
        $idSolicitud = $_POST['idSolicitud'];
        $idItemBaremable = $_POST['idItemBaremable'];
        $notaProvisional = $_POST['notaProvisional'];
        $notaDefinitiva = $_POST['notaDefinitiva'];
        $url = $_POST['url'];
    
        $baremacion = new Baremacion($idConvocatoria, $idSolicitud,$idItemBaremable,$notaProvisional,$notaDefinitiva,$url);
    
        $row = BaremacionRepo::setBaremacion($baremacion);
        if ($row > 0) {
            http_response_code(200);
            echo (json_encode(["status" => "success", "message" => "Baremación añadida correctamente"]));
        } else {
            http_response_code(418);
            echo (json_encode(["status" => "error", "message" => "No se ha podido añadir la baremacion"]));
        }
    }
    
} 
elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idConvocatoria']) && isset($_GET['idSolicitud']) && isset($_GET['idItemBaremable'])) {
        $baremaciones = BaremacionRepo::getBaremacionById($_GET['idConvocatoria'], $_GET['idSolicitud'], $_GET['idItemBaremable']);
    } 
    elseif (isset($_GET['idConvocatoria']) && isset($_GET['idSolicitud'])) {
        $baremaciones = BaremacionRepo::getBaremacionByIdConvocatoriaAndIdSolicitud($_GET['idConvocatoria'], $_GET['idSolicitud'],);
    } 
    else {
        $baremaciones = BaremacionRepo::getBaremaciones();
    }

    $baremacionesJson = json_encode($baremaciones);
    echo ($baremacionesJson);
} 
elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['idConvocatoria']) && isset($_GET['idSolicitud']) && isset($_GET['idItemBaremable'])) {
        $row = BaremacionRepo::deleteBaremacionById($_GET['idConvocatoria'],$_GET['idSolicitud'],$_GET['idSolicitud']) ;
    } 
    elseif (isset($_GET['idConvocatoria']) && isset($_GET['idSolicitud'])) {
        $idConvocatoria = $_GET['idConvocatoria'];
        $idSolicitud = $_GET['idSolicitud'];
        $row = BaremacionRepo::deleteBaremacionByIdConvocatoriaAndIdSolicitud($idConvocatoria, $idSolicitud);
    }
    header('Content-Type: application/json');

        if ($row > 0) {
            http_response_code(200);
            echo (json_encode(["status" => "success", "message" => "Baremacion eliminada correctamente"]));
        } else {
            http_response_code(418);
            echo (json_encode(["status" => "error", "message" => "No se ha podido eliminar la baremacion"]));
        }
} 
elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    
}
