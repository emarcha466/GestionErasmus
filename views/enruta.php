<?php
if (isset($_GET['menu'])) {
    if ($_GET['menu'] == "inicio") {
        require_once './views/verConvocatorias.php';
    }

}else{
    require_once './views/verConvocatorias.php';
}