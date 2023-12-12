<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus\helpers\autocargador.php";

if ($_SERVER['REQUEST_METHOD']=='POST') {
    
}
elseif ($_SERVER['REQUEST_METHOD']=='GET') {
    if(isset($_GET['idConvocatoria'])){
        $destinatarios = ConvocatoriaDestinatarioRepo::getDestinatariosByConvocatoriaId($_GET['idConvocatoria']);
        $destinatariosJson = json_encode($destinatarios);
        echo($destinatariosJson);
    } else {
        http_response_code(400);
        echo json_encode(array("status" => "error", "message" => "No se proporcionó idConvocatoria"));
    }
}
elseif ($_SERVER['REQUEST_METHOD']=='DELETE') {
    if(isset($_GET['idConvocatoria'])){
        $row = ConvocatoriaDestinatarioRepo::deleteDestinatariosByConvocatoriaId($_GET['idConvocatoria']);
        if ($row > 0) {
            echo json_encode(array("status" => "success", "message" => "Destinatarios eliminados correctamente"));
        } else {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "No se pudo eliminar los destinatarios"));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("status" => "error", "message" => "No se proporcionó idConvocatoria"));
    }
}
