<?php
//si el formualario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['accion']) {
        case "Crear nueva convocatoria":
            $_SESSION['convocatoria']['accion'] = "crear";
            header("location:?menu=crearConvocatoria");
            break;
        case "Actualizar convocatoria":
            $_SESSION['convocatoria']['accion'] = "actualizar";
            header("location:?menu=crearConvocatoria");
            break;
        case "Eliminar convocatoria":
            $_SESSION['convocatoria']['accion'] = "eliminar";
            header("location:?menu=crearConvocatoria");
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
        echo("<p class='success'>".$_SESSION['success']."</p>") ;
    }
    unset($_SESSION['success']);
    ?>
    
    <form method="post" action="">
        <input type="submit" name="accion" value="Crear nueva convocatoria" class="btnPantalla">
        <input type="submit" name="accion" value="Actualizar convocatoria" class="btnPantalla">
        <input type="submit" name="accion" value="Eliminar convocatoria" class="btnPantalla">
        <input type="submit" name="accion" value="Listado de todas las convocatorias" class="btnPantalla">
    </form>
</main>