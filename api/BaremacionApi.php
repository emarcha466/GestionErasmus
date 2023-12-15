<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_GET['subirPDF'])) {

        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/GestionErasmus/recursos/documentaciones/";
        $archivos_guardados = array();
        $items = array(); //para guardar los items
        $idItems = explode(',', $_POST['idItems']); // Convierte la cadena de texto a un array
        foreach ($_FILES as $key => $file) {
            // Comprueba si el archivo ha sido subido sin errores
            if ($file['error'] == UPLOAD_ERR_OK) {
                $nombre = $key . ".pdf";
                echo (json_encode($nombre));
                $nombre_temporal = $file['tmp_name'];
                $destino = $target_dir . $nombre;

                // Mueve el archivo subido al directorio de destino
                if (move_uploaded_file($nombre_temporal, $destino)) {
                    echo json_encode("El archivo " . htmlspecialchars($nombre) . " ha sido subido.");
                    $destino_relativo = "./recursos/documentaciones/" . $nombre;
                    echo json_encode("La ruta del archivo es" . $destino);
                    
                    $archivos_guardados[] = $destino;
                    $item = array(
                        'idItem' => array_shift($idItems), // Usa el primer idItem y lo elimina del array
                        'url' => $destino_relativo
                    );
                    $items[] = $item;
                } else {
                    echo json_encode("Lo siento, hubo un error al subir tu archivo.");
                }
            }
        }

        $rows = BaremacionRepo::updateUrlsItems($_POST['idConvocatoria'], $_POST['idSolicitud'], $items);
        if ($rows > 0) {
            http_response_code(200);
            echo (json_encode(["status" => "success", "message" => "URLs actualizadas correctamente"]));
        } else {
            http_response_code(418);
            echo (json_encode(["status" => "error", "message" => "No se ha podido actualizar las URLs"]));
        }
    } elseif (isset($_GET['idConvocatoria']) && isset($_GET['idSolicitud'])) {
        $creado = BaremacionRepo::setItemBaremablesBaremacion($_GET['idConvocatoria'], $_GET['idSolicitud']);
        if ($creado) {
            http_response_code(200);
            echo (json_encode(["status" => "success", "message" => "Items añadidos correctamente"]));
        } else {
            http_response_code(418);
            echo (json_encode(["status" => "error", "message" => "No se ha podido añadir la solicitud"]));
        }
    } else {
        // Recojo las variables para hacer el insert
        $idConvocatoria = $_POST['idConvocatoria'];
        $idSolicitud = $_POST['idSolicitud'];
        $idItemBaremable = $_POST['idItemBaremable'];
        $notaProvisional = $_POST['notaProvisional'];
        $notaDefinitiva = $_POST['notaDefinitiva'];
        $url = $_POST['url'];

        $baremacion = new Baremacion($idConvocatoria, $idSolicitud, $idItemBaremable, $notaProvisional, $notaDefinitiva, $url);

        $row = BaremacionRepo::setBaremacion($baremacion);
        if ($row > 0) {
            http_response_code(200);
            echo (json_encode(["status" => "success", "message" => "Baremación añadida correctamente"]));
        } else {
            http_response_code(418);
            echo (json_encode(["status" => "error", "message" => "No se ha podido añadir la baremacion"]));
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idConvocatoria']) && isset($_GET['idSolicitud']) && isset($_GET['idItemBaremable'])) {
        $baremaciones = BaremacionRepo::getBaremacionById($_GET['idConvocatoria'], $_GET['idSolicitud'], $_GET['idItemBaremable']);
    } elseif (isset($_GET['idConvocatoria']) && isset($_GET['idSolicitud'])) {
        $baremaciones = BaremacionRepo::getBaremacionByIdConvocatoriaAndIdSolicitud($_GET['idConvocatoria'], $_GET['idSolicitud'],);
    } else {
        $baremaciones = BaremacionRepo::getBaremaciones();
    }

    $baremacionesJson = json_encode($baremaciones);
    echo ($baremacionesJson);
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['idConvocatoria']) && isset($_GET['idSolicitud']) && isset($_GET['idItemBaremable'])) {
        $row = BaremacionRepo::deleteBaremacionById($_GET['idConvocatoria'], $_GET['idSolicitud'], $_GET['idSolicitud']);
    } elseif (isset($_GET['idConvocatoria']) && isset($_GET['idSolicitud'])) {
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
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    // Recojo el FormData enviado y creo mi propio $_PUT
    $_PUT = json_decode(file_get_contents("php://input"), true);
    //echo(var_dump($_PUT));
    if (isset($_PUT['idConvocatoria']) && isset($_PUT['idSolicitud']) && isset($_PUT['itemsNotas'])) {

        $idConvocatoria = $_PUT['idConvocatoria'];
        $idSolicitud = $_PUT['idSolicitud'];
        $items = $_PUT['itemsNotas'];

        $rows = BaremacionRepo::updateNotasItems($idConvocatoria, $idSolicitud, $items);

        if ($rows > 0) {
            http_response_code(200);
            echo (json_encode(["status" => "success", "message" => "Puntuación actualizada correctamente"]));
        } else {
            http_response_code(418);
            echo (json_encode(["status" => "error", "message" => "No se ha podido actualizar la puntuación"]));
        }
    } else {
        http_response_code(418);
        echo (json_encode(["status" => "error", "message" => "No se han enviado los datos requeridos"]));
    }
}
