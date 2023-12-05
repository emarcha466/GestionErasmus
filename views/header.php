<header>
    <a href="?menu=inicio" id="logoCabecera"><img src="recursos/img/fuentezuelas.png" alt=""></a>
    <h1>Gestion de becas</h1>
    <?php
    if (isset($_GET['menu']) &&$_GET['menu'] != "login") {
            echo('<a href="?menu=login" class="btnCabecera">Login</a>');
    }elseif(isset($_GET['usuario'])){
        echo('<span id="usuarioLogin"></span>');
    }
    ?>
</header>