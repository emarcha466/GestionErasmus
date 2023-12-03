<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion Becas</title>
    <link rel="stylesheet" href="\GestionErasmus\style\principal.css">
    <link rel="shortcut icon" href="./img/logoSF.png" type="image/x-icon">
</head>

<body>
    <?php
    session_start();
    require_once './views/header.php';
    if (isset($_SESSION['logueado']) && $_SESSION['logueado']) {
        require_once './Vistas/nav.php';
    }
    ?>
    <div id="cuerpo">
        <?php
        require_once './views/enruta.php';
        ?>
    </div>

    <?php
    require_once './views/footer.php';
    ?>

</body>

</html>