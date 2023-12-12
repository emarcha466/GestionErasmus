<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus\helpers\autocargador.php";

if ($_SERVER['REQUEST_METHOD']=='POST')
{

}
elseif ($_SERVER['REQUEST_METHOD']=='GET')	
{
    if(isset($_GET['id'])){
        $nivelIdioma = NivelIdiomaRepo::getNivelIdiomaById($_GET['id']);
        $nivelIdiomaJson = json_encode($nivelIdioma);
        echo($nivelIdiomaJson);
    }else{
        $nivelIdiomas = NivelIdiomaRepo::getNivelIdiomas();
        $nivelIdiomasJson = json_encode($nivelIdiomas);
        echo($nivelIdiomasJson);
    }
}
elseif ($_SERVER['REQUEST_METHOD']=='DELETE')
{
    if(isset($_GET['id'])){
        $id= $_GET['id'];
        $row = NivelIdiomaRepo::deleteNivelIdiomaById($id);

        header('Content-Type: application/json');

        if ($row > 0) {
            http_response_code(200);
            echo (json_encode(["status" => "success", "message" => "Nivel de idioma eliminado correctamente"]));
        } else {
            http_response_code(418);
            echo (json_encode(["status" => "error", "message" => "No se ha podido eliminar el nivel de idioma"]));
        }
    }
}
elseif ($_SERVER['REQUEST_METHOD']=='PUT')
{
    
}