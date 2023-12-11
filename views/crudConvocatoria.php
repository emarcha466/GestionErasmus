<script src="./javaScript/crudConvocatoriaJs.js"></script>
<?php
//si el formualario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['accion']) {
        case "Crear nueva convocatoria":
            $_SESSION['convocatoria']['accion'] = "crear";
            header("location:?menu=crearConvocatoria");
            break;
        case "Modificar":
            $_SESSION['convocatoria']['accion'] = "actualizar";
            header("location:?menu=crearConvocatoria");
            break;
        case "Eliminar":
            $row = ConvocatoriaRepo::deleteConvocatoriaById($_POST['idConvocatoria']);
            if ($row > 0) {
                $_SESSION['success'] = "Convocatoria eliminada correctamente";
            } else {
                $_SESSION['error'] = "No se ha podido eliminar la convocatoria";
            }
            break;
        case "Listado de todas las convocatorias":
            $_SESSION['convocatoria']['accion'] = "listado";
            header("location:?menu=crearConvocatoria");
            break;
    }
}
?>

<main id="crudConvocatoria">
    <h2>Mantenimiento de las convocatorias</h2>
    <?php
    //muestro el mensaje si ha salido correcto el crud
    if (isset($_SESSION['success'])) {
        echo ("<p class='success'>" . $_SESSION['success'] . "</p>");
    }elseif(isset($_SESSION['error'])){
        echo ("<p class='error'>" . $_SESSION['error'] . "</p>");
    }
    unset($_SESSION['success']);
    unset($_SESSION['error']);
    
    ?>
    <div id="listadoConvocatoriasActivas">
        <table id="listadoConvocatorias">
            <thead>
                <tr>
                    <th hidden>id</th>
                    <th>Proyecto</th>
                    <th>Movilidades</th>
                    <th>Duración</th>
                    <th>Tipo</th>
                    <th>Inicio Solicitudes</th>
                    <th>Fin Solicitudes</th>
                    <th>Inicio Pruebas</th>
                    <th>Fin Pruebas</th>
                    <th>Listado Provisional</th>
                    <th>Listado Definitivo</th>
                    <th>Destinos</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbodyListadoConvocatorias">
            </tbody>
        </table>
    </div>
</main>