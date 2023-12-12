<script src="./javaScript/crudConvocatoriaJs.js"></script>
<?php
//si el formualario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['accion']) {
        case "Nueva Convocatoria":
            $_SESSION['accion'] = "crear";
            if(isset($_SESSION['convocatoria'])){
                unset($_SESSION['convocatoria']);
            }
            header("location:?menu=crearConvocatoria");
            break;
        case "Modificar":
            $_SESSION['accion'] = "actualizar";
            $idConvocatoria = $_POST['idConvocatoria'];
            $convocatoria = ConvocatoriaRepo::getConvocatoriaById($idConvocatoria);
            //guardo la id en el localstorage para recogerla con js

            //realizo la redireccion con js para que le de tiempo a guardarse el id en el ls
            echo "<script>
                localStorage.setItem('idConvocatoria', '$idConvocatoria');
                location.href = '?menu=crearConvocatoria';
            </script>";
            //guardo los datos de convocatoria en la session
            $_SESSION['convocatoria'] = $convocatoria;

            //guardo los datos de los destinatarios
            $destinatarios = ConvocatoriaDestinatarioRepo::getDestinatariosByConvocatoriaId($idConvocatoria);
            $_SESSION['destinatarios'] = $destinatarios;


            //header("location:?menu=crearConvocatoria");
            break;
        case "Eliminar":
            $row = ConvocatoriaRepo::deleteConvocatoriaById($_POST['idConvocatoria']);
            if ($row > 0) {
                $_SESSION['success'] = "Convocatoria eliminada correctamente";
            } else {
                $_SESSION['error'] = "No se ha podido eliminar la convocatoria";
            }
            break;
    }
}
?>

<main id="crudConvocatoria">
    <h2>Mantenimiento de las convocatorias</h2>
    <form action="" method="post" id="btnNuevaConvocatoria">
        <input type="submit" name="accion" value="Nueva Convocatoria" class="btnPantalla">
    </form>
    <?php
    //muestro el mensaje si ha salido correcto el crud
    if (isset($_SESSION['success'])) {
        echo ("<p class='success'>" . $_SESSION['success'] . "</p>");
        unset($_SESSION['success']);
    } elseif (isset($_SESSION['error'])) {
        echo ("<p class='error'>" . $_SESSION['error'] . "</p>");
        unset($_SESSION['error']);
    }

    ?>
    <div id="listadoConvocatoriasActivas">
        <table id="listadoConvocatorias">
            <thead>
                <tr>
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