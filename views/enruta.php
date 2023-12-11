<?php
if (isset($_GET['menu'])) {
    if ($_GET['menu'] == "inicio") {
        require_once './views/verConvocatorias.php';
    }elseif ($_GET['menu'] == "login") {
        require_once './views/autentifica.php';
    }elseif ($_GET['menu'] == "estadoConvoLogin") {
        require_once './views/estadoConvocatoriaLogin.php';
    }elseif ($_GET['menu'] == "inicioAdmin" && isset($_SESSION['logueado'])) {
        require_once './views/crudConvocatoria.php';
    }
    elseif ($_GET['menu'] == "crearConvocatoria" && isset($_SESSION['logueado'])) {
        require_once './views/formularioConvocatoria.php';
    }

    

}else{
    if(isset($_SESSION['logueado'])){
        require_once './views/crudConvocatoria.php';
    }else{
        require_once './views/verConvocatorias.php';
    }
    
}