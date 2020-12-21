<?php
require_once "funciones.php";
$instance = BaseDatos::getInstance();
if (isset($_POST["login"])) {
    $usuario = $_POST["usuario"];
    $contraseña = md5($_POST["contraseña"]);
    if (logUsuario($usuario, $contraseña)) {
        $_SESSION["usuario"] = $instance::getUsuario($usuario);
        header("Location: portada.php");
    } else {
        $veriContraseña = false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="estilos.css">
    <title>Inicio de Sesion</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand px-5 volver" href="portada.php">Inicio</a>
        <a class="navbar-brand px-5 volver" href="productos.php">Productos</a>
        <?php if (!isset($_SESSION["usuario"])) : ?>
            <a class="navbar-brand px-5 volver" href="registro.php">Registrarse</a>
        <?php endif; ?>
        <?php if (isset($_SESSION["usuario"])) : ?>
            <a class="navbar-brand px-5 volver" href="perfil.php"><?= "Perfil de: " . $_SESSION["usuario"]["usuario"] ?></a>
            <?php if ($_SESSION["usuario"]["rol"] == "administrador") : ?>
                <a class="navbar-brand px-5 volver" href="admin.php">Administración</a>
                <a class="navbar-brand px-5 volver" href="almacen.php">Almacen</a>
            <?php endif; ?>
            <a class="navbar-brand px-5 volver" href="cesta.php">Cesta</a>
        <?php endif; ?>
    </nav>
    <div class="container" id="main">
        <div class="row mx-0 mt-5 d-flex align-content-center justify-content-center">
            <div class="shadow col  mx-2 d-flex py-2 border border-secondary rounded fondo-producto text-center d-flex align-content-center justify-content-center">
                <form action="" method="POST">
                    <fieldset>
                        <legend>Inicio de sesión</legend>
                        <input class="form-control text-center" type="text" name="usuario" placeholder="usuario"><br>
                        <input class="form-control text-center" type="password" name="contraseña" placeholder="contraseña">
                        <?php if (isset($veriContraseña)) : ?>
                            Contraseña incorrecta
                        <?php endif; ?>
                        <br>
                        <input class="form-control botones" type="submit" name="login" value="Iniciar"><br>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</body>

</html>