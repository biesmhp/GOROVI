<?php
require_once "funciones.php";
    if (!$_SESSION["usuario"]) {
        header("Location: portada.php");
    }
    if (isset($_POST["cerrar"])) {
        $_SESSION["usuario"]=null;
        header("Location: portada.php");
    }
    if (isset($_POST["borrar"])) {
        delUsuario($_SESSION["usuario"]["usuario"]);
        $_SESSION["usuario"]=null;
        header("Location: portada.php");
    }
    if (isset($_POST["actualizar"])) {
        echo "control 1";
        if ($_POST["usuario"]!=null) {
            if (getUsuario($_POST["usuario"])==null||getUsuario($_POST["usuario"])["usuario"]==$_SESSION["usuario"]["usuario"]) {
                echo "control 3";
                $usuario = $_POST["usuario"];
                $nombre = $_POST["nombre"];
                $apellidos = $_POST["apellidos"];
                $email = $_POST["email"];
                updateUsuario($_SESSION["usuario"]["id"],$usuario,$nombre,$apellidos,$email);
                $_SESSION["usuario"]=getUsuario($usuario);
                header("Location: portada.php");
            }else{
                $veriUser = "El usuario introducido ya existe";
            }
        }else{
            $veriUser = "El usuario introducido no puede ser nulo.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de usuario</title>
</head>
<body>
    <nav>
        <a href="portada.php">Inicio</a>
    </nav>
    <form action="" method="POST">
        <fieldset>
            <legend>Datos</legend>
            <input type="text" name="usuario" value="<?=$_SESSION["usuario"]["usuario"]?>" placeholder="usuario" required><br>
            <input type="text" name="nombre" value="<?=$_SESSION["usuario"]["nombre"]?>" placeholder="nombre" required><br>
            <input type="text" name="apellidos" value="<?=$_SESSION["usuario"]["apellidos"]?>" placeholder="apellidos" required><br>
            <input type="email" name="email" value="<?=$_SESSION["usuario"]["email"]?>" placeholder="email" required><br>
            <input type="submit" name="actualizar" value="Actualizar">
        </fieldset>
    </form>
    <form action="" method="POST">
        <input type="submit" name="cerrar" value="Cerrar sesión">
    </form>
    <br>
    <form action="" method="POST">
        <input type="submit" name="borrar" value="Borrar este usuario">
    </form>
</body>
</html>