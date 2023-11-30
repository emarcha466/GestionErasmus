<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";

if ($_SERVER['REQUEST_METHOD']=='POST')
{

}
elseif ($_SERVER['REQUEST_METHOD']=='GET')	
{
    if(isset($_GET['codigoGrupo'])){
        $destinatario = DestinatarioRepo::getDestinatarioByCodigoGrupo($_GET['codigoGrupo']);
        $destinatarioJson = json_encode($destinatario);
        echo($destinatarioJson);
    }else{
        $destinatarios = DestinatarioRepo::getDestinatarios();
        $destinatariosJson = json_encode($destinatarios);
        echo($destinatariosJson);
    }
}
elseif ($_SERVER['REQUEST_METHOD']=='DELETE')
{
    if(isset($_GET['codigoGrupo'])){
        $codigoGrupo= $_GET['codigoGrupo'];
        $row = DestinatarioRepo::deleteDestinatarioByCodigoGrupo($codigoGrupo);

        header('Content-Type: application/json');

        if ($row > 0) {
            http_response_code(200);
            echo (json_encode(["status" => "success", "message" => "Destinatario eliminado correctamente"]));
        } else {
            http_response_code(418);
            echo (json_encode(["status" => "error", "message" => "No se ha podido eliminar el destinatario"]));
        }
    }
}
elseif ($_SERVER['REQUEST_METHOD']=='PUT')
{
    
}
