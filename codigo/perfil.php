<?php
require_once "funciones.php";
$instance = BaseDatos::getInstance();
if (!$_SESSION["usuario"]) {
    header("Location: portada.php");
}
if (isset($_POST["cerrar"])) {
    $_SESSION["usuario"] = null;
    $_SESSION["cesta"] = null;
    header("Location: portada.php");
}
if (isset($_POST["borrar"])) {
    $instance::delUsuario($_SESSION["usuario"]["usuario"]);
    $_SESSION["usuario"] = null;
    header("Location: portada.php");
}
if (isset($_POST["actualizar"])) {
    if ($_POST["usuario"] != null) {
        if ($instance::getUsuario($_POST["usuario"]) == null || $instance::getUsuario($_POST["usuario"])["usuario"] == $_SESSION["usuario"]["usuario"]) {
            $usuario = $_POST["usuario"];
            $nombre = $_POST["nombre"];
            $apellidos = $_POST["apellidos"];
            $email = $_POST["email"];
            updateUsuario($_SESSION["usuario"]["id"], $usuario, $nombre, $apellidos, $email);
            $_SESSION["usuario"] = $instance::getUsuario($usuario);
            header("Location: portada.php");
        } else {
            $veriUser = "El usuario introducido ya existe";
        }
    } else {
        $veriUser = "El usuario introducido no puede ser nulo.";
    }
}
if (isset($_POST["cambiar"])) {
    $passActual = md5($_POST["pass0"]);
    $pass1 = md5($_POST["pass1"]);
    $pass2 = md5($_POST["pass2"]);
    if (logUsuario($_SESSION["usuario"]["usuario"], $passActual)) {
        $veriPassActual = true;
        if ($pass1 == $pass2) {
            $veriContraseña = true;
            updatePassUsuario($_SESSION["usuario"]["id"], $pass1);
        } else {
            $veriContraseña = false;
        }
    } else {
        $veriPassActual = false;
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
    <title>Perfil de usuario</title>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand px-5 volver" href="productos.php">Productos</a>
        <?php if (!isset($_SESSION["usuario"])) : ?>
            <a class="navbar-brand px-5 volver" href="registro.php">Registrarse</a>
            <a class="navbar-brand px-5 volver" href="login.php">Iniciar sesión</a>
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
            <!-- Imagen de usuario -->
            <div class="col  m-0 py-2 text-center align-content-center justify-content-center">
                <img src="homer.jpg" alt="" style="border-radius:50%;width:150px;height:150px">
                <!--Cerrar sesión-->
                <form class="mt-3 shadow" action="" method="POST">
                    <input class="form-control botones" type="submit" name="cerrar" value="Cerrar sesión">
                </form>
            </div>
            <!--Actualizar los datos del usuario-->
            <div class="shadow col  mx-2 d-flex py-2 border border-secondary rounded fondo-producto text-center d-flex align-content-center justify-content-center">
                <form action="" method="POST">
                    <fieldset>
                        <legend>Datos:</legend>
                        <input class="form-control" type="text" name="usuario" value="<?= $_SESSION["usuario"]["usuario"] ?>" placeholder="usuario" required><br>
                        <input class="form-control" type="text" name="nombre" value="<?= $_SESSION["usuario"]["nombre"] ?>" placeholder="nombre" required><br>
                        <input class="form-control" type="text" name="apellidos" value="<?= $_SESSION["usuario"]["apellidos"] ?>" placeholder="apellidos" required><br>
                        <input class="form-control" type="email" name="email" value="<?= $_SESSION["usuario"]["email"] ?>" placeholder="email" required><br>
                        <input class="form-control" type="submit" name="actualizar" value="Actualizar">
                    </fieldset>
                </form>
            </div>

            <!--Cambiar la contraseña-->
            <div class="shadow col  mx-2 d-flex py-2 border border-secondary rounded fondo-producto text-center d-flex align-content-center justify-content-center">
                <form action="" method="POST">
                    <fieldset>
                        <legend>Cambiar la contraseña:</legend>
                        <input class="form-control" type="password" name="pass0" placeholder="Contraseña actual" required>
                        <?php if (isset($_POST["cambiar"]) && !$veriPassActual) : ?>
                            Contraseña incorrecta
                        <?php endif; ?>
                        <br>
                        <input class="form-control" type="password" name="pass1" placeholder="Nueva contraseña" required><br>
                        <input class="form-control" type="password" name="pass2" placeholder="Confirmar nueva contraseña" required>
                        <?php if (isset($veriContraseña) && !$veriContraseña) : ?>
                            La contraseña no coincide
                        <?php endif; ?>
                        <br>
                        <input class="form-control" type="submit" name="cambiar" value="Cambiar">
                    </fieldset>
                </form>
            </div>
            <!--Borrar usuario-->
            <div class="col  m-0 d-flex py-2 rounded text-center d-flex align-content-center justify-content-center">
                <form action="" method="POST">
                    <label class="borrar-usuario" for="borrar">Atención, esta acción es irreversible</label>
                    <input class="form-control shadow" type="submit" name="borrar" value="Borrar este usuario" style="background-color: rgb(251, 143, 143);">
                </form>
            </div>
        </div>
    </div>
</body>

</html>