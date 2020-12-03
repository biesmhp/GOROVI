<?php
require_once "funciones.php";
    if (isset($_POST["login"])) {
        $usuario = $_POST["usuario"];
        $contraseña = md5($_POST["contraseña"]);
        if (logUsuario($usuario,$contraseña)) {
            $_SESSION["usuario"]=getUsuario($usuario);
            header("Location: portada.php");
        }else{
            echo "Error de autentificación";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesion</title>
</head>
<body>
    <nav>
        <a href="portada.php">Inicio</a>
    </nav>
    <form action="" method="POST">
        <fieldset>
            <legend>Inicio de sesión</legend>
            <input type="text" name="usuario" placeholder="usuario"><br>
            <input type="password" name="contraseña" placeholder="contraseña"><br>
            <input type="submit" name="login" value="Iniciar"><br>
        </fieldset>
    </form>
</body>
</html>