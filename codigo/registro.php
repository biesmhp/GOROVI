<?php
require_once "funciones.php";
$instance = BaseDatos::getInstance();
# Ejecuta un pequeño script para dar un aviso (debes cerrar sesión antes de crear otro usuario)
if (isset($_SESSION["usuario"])) {
    echo '<script type="text/javascript">alert("Cierra sesión antes");window.location.href="perfil.php";</script>';
    //header("Location: perfil.php");
}
if (isset($_POST["registro"])) {
    $usuario = $_POST["usuario"];
    $contraseña = md5($_POST["contraseña"]);
    $contraseña2 = md5($_POST["contraseña2"]);
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $email = $_POST["email"];
    if ($contraseña == $contraseña2) {
        $veriContraseña = true;
    } else {
        $veriContraseña = false;
    }
    if ($instance::getUsuario($usuario) == null) {
        $veriUser = true;
    } else {
        $veriUser = false;
    }
    if ($veriContraseña && $veriUser) {
        $instance::addUsuario($usuario, $contraseña, $nombre, $apellidos, $email);
        $_SESSION["usuario"] = $instance::getUsuario($usuario);
        header("Location: portada.php");
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
    <title>Registrarse</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand px-5 volver" href="portada.php">Inicio</a>
        <a class="navbar-brand px-5 volver" href="productos.php">Productos</a>
        <?php if (!isset($_SESSION["usuario"])) : ?>
            <a class="navbar-brand px-5 volver" href="login.php">Iniciar sesión</a>
        <?php endif; ?>
        <?php if (isset($_SESSION["usuario"])) : ?>
            <?php if ($_SESSION["usuario"]["rol"] == "administrador") : ?>
                <a class="navbar-brand px-5 volver" href="admin.php">Administración</a>
                <a class="navbar-brand px-5 volver" href="almacen.php">Almacen</a>
            <?php endif; ?>
            <a class="navbar-brand px-5 volver" href="cesta.php">Cesta</a>
        <?php endif; ?>
    </nav>
    <div class="container" id="main">
        <div class="shadow col  mx-2 my-3 d-flex py-2 border border-secondary rounded fondo-producto text-center d-flex align-content-center justify-content-center">
            <form action="" method="POST">
                <fieldset>
                    <legend>Registro</legend>
                    <!--Usuario-->
                    <?php if (isset($_POST["registro"])) : ?>
                        <input class="form-control text-center" type="text" name="usuario" value="<?= $usuario ?>" placeholder="usuario" required>
                    <?php else : ?>
                        <input class="form-control text-center" type="text" name="usuario" placeholder="usuario" required>
                    <?php endif; ?>
                    <?php if (isset($_POST["registro"]) && !$veriUser) : ?>
                        El usuario ya está en uso
                    <?php endif; ?>
                    <br>
                    <!--Contraseña-->
                    <input class="form-control text-center" type="password" name="contraseña" placeholder="contraseña" required><br>
                    <input class="form-control text-center" type="password" name="contraseña2" placeholder="confirmar contraseña" required>
                    <?php if (isset($_POST["registro"]) && !$veriContraseña) : ?>
                        La contraseña no coincide
                    <?php endif; ?>
                    <br>
                    <!--Nombre-->
                    <?php if (isset($_POST["registro"])) : ?>
                        <input class="form-control text-center" type="text" name="nombre" value="<?= $nombre ?>" placeholder="nombre" required>
                    <?php else : ?>
                        <input class="form-control text-center" type="text" name="nombre" placeholder="nombre" required>
                    <?php endif; ?>
                    <br>
                    <!--Apellidos-->
                    <?php if (isset($_POST["registro"])) : ?>
                        <input class="form-control text-center" type="text" name="apellidos" value="<?= $apellidos ?>" placeholder="apellidos" required>
                    <?php else : ?>
                        <input class="form-control text-center" type="text" name="apellidos" placeholder="apellidos" required>
                    <?php endif; ?>
                    <br>
                    <!--Email-->
                    <?php if (isset($_POST["registro"])) : ?>
                        <input class="form-control text-center" type="email" name="email" value="<?= $email ?>" placeholder="email" required>
                    <?php else : ?>
                        <input class="form-control text-center" type="email" name="email" placeholder="email" required>
                    <?php endif; ?>
                    <br>
                    <input class="btn btn-primary botones" type="submit" name="registro" value="Registrarse"><br>
                </fieldset>
            </form>
        </div>
    </div>
</body>

</html>