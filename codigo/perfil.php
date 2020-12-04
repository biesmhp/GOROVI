<?php
require_once "funciones.php";
    if (!$_SESSION["usuario"]) {
        header("Location: portada.php");
    }
    if (isset($_POST["cerrar"])) {
        $_SESSION["usuario"]=null;
        $_SESSION["cesta"]=null;
        header("Location: portada.php");
    }
    if (isset($_POST["borrar"])) {
        delUsuario($_SESSION["usuario"]["usuario"]);
        $_SESSION["usuario"]=null;
        header("Location: portada.php");
    }
    if (isset($_POST["actualizar"])) {
        if ($_POST["usuario"]!=null) {
            if (getUsuario($_POST["usuario"])==null||getUsuario($_POST["usuario"])["usuario"]==$_SESSION["usuario"]["usuario"]) {
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
    if (isset($_POST["cambiar"])) {
        $passActual=md5($_POST["pass0"]);
        $pass1=md5($_POST["pass1"]);
        $pass2=md5($_POST["pass2"]);
        if (logUsuario($_SESSION["usuario"]["usuario"],$passActual)) {
            $veriPassActual=true;
            if ($pass1==$pass2) {
                $veriContraseña=true;
                updatePassUsuario($_SESSION["usuario"]["id"],$pass1);
            }else{
                $veriContraseña=false;
            }
        }else{
            $veriPassActual=false;
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
    <!--Actualizar los datos del usuario-->
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
    <!--Cambiar la contraseña-->
    <form action="" method="POST">
        <fieldset>
            <legend>Cambiar la contraseña</legend>
            <input type="password" name="pass0" placeholder="Contraseña actual" required>
            <?php if(isset($_POST["cambiar"])&&!$veriPassActual) :?>
                Contraseña incorrecta
            <?php endif ;?>
            <br>
            <input type="password" name="pass1" placeholder="Nueva contraseña" required><br>
            <input type="password" name="pass2" placeholder="Confirmar nueva contraseña" required>
            <?php if(isset($veriContraseña)&&!$veriContraseña) :?>
                La contraseña no coincide
            <?php endif ;?>
            <br>
            <input type="submit" name="cambiar" value="Cambiar">
        </fieldset>
    </form>
    <!--Cerrar sesión-->
    <form action="" method="POST">
        <input type="submit" name="cerrar" value="Cerrar sesión">
    </form>
    <br>
    <!--Borrar usuario-->
    <form action="" method="POST">
    <fieldset>
        <legend>ATENCION, esta acción es irreversible</legend>
        <input type="submit" name="borrar" value="Borrar este usuario">
    </fieldset>
    </form>
</body>
</html>