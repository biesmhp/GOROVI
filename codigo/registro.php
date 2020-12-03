<?php
require_once "funciones.php";
    # Ejecuta un pequeño script para dar un aviso (debes cerrar sesión antes de crear otro usuario)
    if (isset($_SESSION["usuario"])) {
        echo'<script type="text/javascript">alert("Cierra sesión antes");window.location.href="perfil.php";</script>';
        //header("Location: perfil.php");
    }
    if (isset($_POST["registro"])) {
        $usuario = $_POST["usuario"];
        $contraseña = md5($_POST["contraseña"]);
        $contraseña2 = md5($_POST["contraseña2"]);
        $nombre = $_POST["nombre"];
        $apellidos = $_POST["apellidos"];
        $email = $_POST["email"];
        if ($contraseña==$contraseña2) {
            $veriContraseña = true;
        }else{
            $veriContraseña = false;
        }
        if (getUsuario($usuario)==null) {
            $veriUser = true;
        }else{
            $veriUser = false;
        }
        if ($veriContraseña&&$veriUser) {
            addUsuario($usuario,$contraseña,$nombre,$apellidos,$email);
            $_SESSION["usuario"]=getUsuario($usuario);
            header("Location: portada.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
</head>
<body>
    <nav>
        <a href="portada.php">Inicio</a>
    </nav>
    <form action="" method="POST">
        <fieldset>
            <legend>Registro</legend>
            <!--Usuario-->
            <?php if(isset($_POST["registro"])):?>
                <input type="text" name="usuario" value="<?=$usuario?>" placeholder="usuario" required>
            <?php else :?>
                <input type="text" name="usuario" placeholder="usuario" required>
            <?php endif ;?>
            <?php if(isset($_POST["registro"])&&!$veriUser) :?>
                El usuario ya está en uso
            <?php endif ;?>
            <br>
            <!--Contraseña-->
            <input type="password" name="contraseña" placeholder="contraseña" required><br>
            <input type="password" name="contraseña2" placeholder="confirmar contraseña" required>
            <?php if(isset($_POST["registro"])&&!$veriContraseña) :?>
                La contraseña no coincide
            <?php endif ;?>
            <br>
            <!--Nombre-->
            <?php if(isset($_POST["registro"])):?>
                <input type="text" name="nombre" value="<?=$nombre?>" placeholder="nombre" required>
            <?php else :?>
                <input type="text" name="nombre" placeholder="nombre" required>
            <?php endif ;?>
            <br>
            <!--Apellidos-->
            <?php if(isset($_POST["registro"])):?>
                <input type="text" name="apellidos" value="<?=$apellidos?>" placeholder="apellidos" required>
            <?php else :?>
                <input type="text" name="apellidos" placeholder="apellidos" required>
            <?php endif ;?>
            <br>
            <!--Email-->
            <?php if(isset($_POST["registro"])):?>
                <input type="email" name="email" value="<?=$email?>" placeholder="email" required>
            <?php else :?>
                <input type="email" name="email" placeholder="email" required>
            <?php endif ;?>
            <br>
            <input type="submit" name="registro" value="Registrarse"><br>
        </fieldset>
    </form>
</body>
</html>