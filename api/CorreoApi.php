<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus\helpers\autocargador.php";

if ($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['destinatario']) && isset($_POST['asunto'])&& isset($_POST['cuerpo'])){
        $correo = new ServicioCorreos($_POST['destinatario'],$_POST['asunto'],$_POST['cuerpo']);
        $enviado =$correo -> enviar();
        if($enviado){
            http_response_code(200);
            echo json_encode(array("status" => "success", "message" => "Email enviado correctamente"));
        } else {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "No se pudo enviar el email"));
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