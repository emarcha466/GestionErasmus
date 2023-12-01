<?php
if (isset($_GET['menu'])) {
    if ($_GET['menu'] == "inicio") {
        require_once './Vistas/landing.php';
    }
    if ($_GET['menu'] == "login") {
        require_once './Vistas/autentifica.php';
    }
    if ($_GET['menu'] == "cerrarsesion") {
        require_once './Vistas/cerrarsesion.php';
    
    }
    if ($_GET['menu'] == "creaUsuario") {
        require_once './Vistas/creaUsuario.php';
    
    }
    if ($_GET['menu'] == "mantenimientoUsuarios") {
        require_once './Vistas/mantenimientoUsuario.php';
    
    }
    if ($_GET['menu'] == "crearCuenta") {
        require_once './Vistas/registro.php';
    
    }
    if ($_GET['menu'] == "mantenimientoPreguntas") {
        require_once './Vistas/mantenimientoPregunta.php';
    }
    if ($_GET['menu'] == "examenRapido") {
        require_once './Vistas/crearExamenRapido.php';
    }
    if ($_GET['menu'] == "aceptarUsuarios") {
        require_once './Vistas/aceptarUsuarios.php';
    }
    if ($_GET['menu'] == "examen") {
        require_once './Vistas/examen.php';
    }
    if ($_GET['menu'] == "examenesRealizados") {
        require_once './Vistas/examenesRealizados.php';
    }

}else{
    //require_once './Vistas/landing.php';
}