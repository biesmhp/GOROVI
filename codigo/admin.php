<?php
require_once "funciones.php";
    if (isset($_SESSION["usuario"])) {
        if (!($_SESSION["usuario"]["rol"]=="administrador")) {
            echo'<script type="text/javascript">alert("Página solo para administradores");window.location.href="portada.php";</script>';
        }
    }else{
        echo'<script type="text/javascript">alert("Página solo para administradores");window.location.href="portada.php";</script>';
    }

    # Borra el usuario seleccionado si no es el usado actualmente
    if (isset($_POST["borrar"])) {
        if (!($_POST["usuarios"]==$_SESSION["usuario"]["usuario"])) {
            delUsuario($_POST["usuarios"]);
        }
    }
    # Asciende a admin al usuario seleccionado si no es el usado actualmente
    if (isset($_POST["ascender"])) {
        if (!($_POST["usuarios"]==$_SESSION["usuario"]["usuario"])) {
            upgradeUsuario($_POST["usuarios"]);
        }
    }
    # Quita del admin al usuario seleccionado si no es el usado actualmente
    if (isset($_POST["descender"])) {
        if (!($_POST["usuarios"]==$_SESSION["usuario"]["usuario"])) {
            downgradeUsuario($_POST["usuarios"]);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admins</title>
</head>
<body>
    <nav>
        <a href="portada.php">Inicio</a>
    </nav>
    <!--Muestra todos los usuarios y sus campos-->
    <?php if(isset($_POST["ver"])){print_r2(getUsuarios());}?>
    <form action="" method="POST">
        <input type="submit" name="ver" value="Ver todos los usuarios">
    </form>
    <form action="" method="POST">
        <select name="usuarios">
            <?php foreach(getUsuarios() as $usuario) :?>
                <option value="<?=$usuario["usuario"]?>"><?=$usuario["usuario"]?></option>
            <?php endforeach ;?>
        </select>
        <input type="submit" name="borrar" value="Borrar usuario">
    </form>
    <form action="" method="POST">
        <select name="usuarios">
            <?php foreach(getUsuarios() as $usuario) :?>
                <option value="<?=$usuario["usuario"]?>"><?=$usuario["usuario"]?></option>
            <?php endforeach ;?>
        </select>
        <input type="submit" name="ascender" value="Convertir en admin">
    </form>
    <form action="" method="POST">
        <select name="usuarios">
            <?php foreach(getUsuarios() as $usuario) :?>
                <option value="<?=$usuario["usuario"]?>"><?=$usuario["usuario"]?></option>
            <?php endforeach ;?>
        </select>
        <input type="submit" name="descender" value="Quitar de admin">
    </form>
    <form action="" method="POST">
                
    </form>
    <a href="almacen.php">Almacén</a>
</body>
</html>