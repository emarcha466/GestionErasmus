<?php
    $valida=new Validacion();
    if(isset($_POST['login']))
    {
        $valida->Requerido('usuario');
        $valida->Requerido('contrasena');
        //Comprobamos validacion
        if($valida->ValidacionPasada()){
            if(login::Identifica($_POST['usuario'],$_POST['contrasena'])){
                $user = userRepo::getUserByUsuario($_POST['usuario']);
                    $_SESSION['usuario'] = $user->getUsuario();
                    $_SESSION['logueado'] = true;
                    header("location:?menu=inicio");
                
            }else {
                $_SESSION['login_error'] = true;
            }
        }else {
            $_SESSION['campos_vacios'] = true;
        }
    }
?>

<main id="autentifica">
    <form action='' method='post' novalidate id="autentifica">
        <h2>Inicie sesión</h2>
            <input type='text' name='usuario' placeholder='Usuario' required='required'>
            <input type='password' name='contrasena' placeholder='Contraseña' required='required'>
        <div>
        <?php
            if(isset($_SESSION['login_error']) && $_SESSION['login_error']) {
                echo("<p>Usuario o contraseña incorrectos</p>");
                unset($_SESSION['login_error']);
            }elseif (isset($_SESSION['campos_vacios']) && $_SESSION['campos_vacios']) {
                echo("<p>Debe rellenar ambos</p>");
                unset($_SESSION['campos_vacios']);
            }elseif (isset($_SESSION['no_rol']) && $_SESSION['no_rol']) {
                echo("<p>El usuario se encuentra en revisión</p>");
                unset($_SESSION['no_rol']);
            }
            ?>
        </div>
            <button type='submit' name='login' id="btnLogin" class="btnPantalla">Iniciar sesión</button>
    </form>
</main>