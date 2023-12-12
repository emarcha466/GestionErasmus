<?php
if (isset($_GET['menu'])) {
    if ($_GET['menu'] == "inicio") {
        require_once './views/verConvocatorias.php';
    }elseif ($_GET['menu'] == "login") {
        require_once './views/autentifica.php';
    }elseif ($_GET['menu'] == "estadoSolicitudLogin") {
        require_once './views/estadoSolicitudLogin.php';
    }elseif ($_GET['menu'] == "realizarSolicitud") {
        require_once './views/realizarSolicitud.php';
    }elseif ($_GET['menu'] == "inicioAdmin" && isset($_SESSION['logueado'])) {
        require_once './views/crudConvocatoria.php';
    }elseif ($_GET['menu'] == "crearConvocatoria" && isset($_SESSION['logueado'])) {
        require_once './views/formularioConvocatoria.php';
    }elseif ($_GET['menu'] == "revisionSolicitudes" && isset($_SESSION['logueado'])) {
        require_once './views/revisionSolicitudes.php';
    }

}else{
    if(isset($_SESSION['logueado'])){
        require_once './views/crudConvocatoria.php';
    }else{
        require_once './views/verConvocatorias.php';
    }
    
}