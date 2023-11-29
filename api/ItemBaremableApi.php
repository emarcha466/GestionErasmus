<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";

if ($_SERVER['REQUEST_METHOD']=='POST')
{

}
elseif ($_SERVER['REQUEST_METHOD']=='GET')	
{
    if(isset($_GET['id'])){
        $itemBaremable = ItemBaremableRepo::getItemBaremableById($_GET['id']);
        $itemBaremableJson = json_encode($itemBaremable);
        echo($itemBaremableJson);
    }else{
        $itemsBaremables = ItemBaremableRepo::getItemBaremables();
        $itemsBaremablesJson = json_encode($itemsBaremables);
        echo($itemsBaremablesJson);
    }
}
elseif ($_SERVER['REQUEST_METHOD']=='DELETE')
{
    if(isset($_GET['id'])){
        $id= $_GET['id'];
        $row = ItemBaremableRepo::deleteItemBaremableById($id);

        header('Content-Type: application/json');

        if ($row > 0) {
            http_response_code(200);
            echo (json_encode(["status" => "success", "message" => "Item baremable eliminado correctamente"]));
        } else {
            http_response_code(418);
            echo (json_encode(["status" => "error", "message" => "No se ha podido eliminar el item baremable"]));
        }
    }
}
elseif ($_SERVER['REQUEST_METHOD']=='PUT')
{
    
}
?>
