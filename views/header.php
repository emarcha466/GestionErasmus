<header>
    <a href="?menu=inicio" id="logoCabecera"><img src="recursos/img/fuentezuelas.png" alt=""></a>
    <h1>Gestion de becas</h1>
    <?php
    if(isset($_SESSION['usuario'])){
        echo('<div id="userLogin">');
        echo('<span id="usuarioLogin">'.$_SESSION['usuario'].'</span>');
        echo('<a href="?logueo=cerrar" class="btnCabecera">Cerrar Sesión</a>');
        if (isset($_GET['logueo'])) {
            session::deleteUserSession();
        }
        echo('</div>');
    }elseif (isset($_GET['menu']) && $_GET['menu'] == "login") {
        
    }else{
        echo('<a href="?menu=login" class="btnCabecera">Login</a>');
    }
    ?> 
</header>