<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus\helpers\autocargador.php";

if ($_SERVER['REQUEST_METHOD']=='POST') {
    // Handle POST request here
}
elseif ($_SERVER['REQUEST_METHOD']=='GET') {
    if(isset($_GET['idConvocatoria'])){
        $itemsBaremables = ConvocatoriaItemBaremableRepo::getItemsBaremablesByConvocatoriaId($_GET['idConvocatoria']);
        $itemsBaremablesJson = json_encode($itemsBaremables);
        echo($itemsBaremablesJson);
    } else {
        http_response_code(400);
        echo json_encode(array("status" => "error", "message" => "No se proporcionó idConvocatoria"));
    }
}
elseif ($_SERVER['REQUEST_METHOD']=='DELETE') {
    if(isset($_GET['idConvocatoria'])){
        $row = ConvocatoriaItemBaremableRepo::deleteItemsBaremablesByConvocatoriaId($_GET['idConvocatoria']);
        if ($row > 0) {
            echo json_encode(array("status" => "success", "message" => "Items baremables eliminados correctamente"));
        } else {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "No se pudo eliminar los items baremables"));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("status" => "error", "message" => "No se proporcionó idConvocatoria"));
    }
}
?>
