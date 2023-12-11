<nav id="menu">
    <ul>
        <?php
        if(isset($_SESSION['logueado']) && $_SESSION['logueado']){
            echo('<li><a href="?menu=inicioAdmin">Mantenimiento Convocatorias</a></li>');
        }else{
            echo('<li><a href="?menu=inicio">Convocatorias Activas</a></li>');
            echo('<li><a href="?menu=estadoConvoLogin">Estado de Convocatoria</a></li>');
        }
        ?>
    </ul>
</nav>