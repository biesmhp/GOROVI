<?php
require_once "funciones.php";
$instance = BaseDatos::getInstance();
    if (isset($_POST["login"])) {
        $usuario = $_POST["usuario"];
        $contraseña = md5($_POST["contraseña"]);
        if (logUsuario($usuario,$contraseña)) {
            $_SESSION["usuario"]=$instance::getUsuario($usuario);
            header("Location: portada.php");
        }else{
            $veriContraseña=false;
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
            <input type="password" name="contraseña" placeholder="contraseña">
            <?php if(isset($veriContraseña)) :?>
                Contraseña incorrecta
            <?php endif ;?>
            <br>
            <input type="submit" name="login" value="Iniciar"><br>
        </fieldset>
    </form>
</body>
</html>