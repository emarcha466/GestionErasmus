<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus\helpers\autocargador.php";

if ($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['nombrePdf']) && isset($_POST['contenidoHtml'])){
        $nombrePdf = $_POST['nombrePdf'];
        $contenidoHtml = $_POST['contenidoHtml'];

        $servicioPdf = new ServicioPDF($nombrePdf, $contenidoHtml);
        $nombrePdf = $servicioPdf->generar();

        if(file_exists($nombrePdf)){
            $file = file_get_contents($nombrePdf);
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename=' . $nombrePdf);
            echo $file;
        } else {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "No se pudo generar el PDF"));
        }
    }
}
elseif ($_SERVER['REQUEST_METHOD']=='GET')	
{
    
}
elseif ($_SERVER['REQUEST_METHOD']=='DELETE')
{
    
}
elseif ($_SERVER['REQUEST_METHOD']=='PUT')
{
    
}
?>