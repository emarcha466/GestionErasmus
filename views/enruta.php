<?php
if (isset($_GET['menu'])) {
    if ($_GET['menu'] == "inicio") {
        require_once './views/verConvocatorias.php';
    }elseif ($_GET['menu'] == "login") {
        require_once './views/autentifica.php';
    }

}else{
    require_once './views/verConvocatorias.php';
}