<?php
require_once "funciones.php";

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOROVI</title>
</head>
<body>
    <nav>
        <a href="login.php">Inicio de sesion</a>
        <?php if(!isset($_SESSION)) :?>
            <a href="registro.php">Registrarse</a>
        <?php endif ;?>
        <a href="productos.php">Productos</a>
    </nav>
    <?php if(isset($_SESSION["usuario"])) :?>
        <a href="perfil.php"><?= "Perfil de: ".$_SESSION["usuario"]["usuario"]?></a>
        <?php if($_SESSION["usuario"]["rol"]=="administrador") :?>
            <a href="admin.php">Administración</a>
            <a href="almacen.php">Almacen</a>
        <?php endif ;?>
        <a href="cesta.php">Cesta</a>
    <?php endif ;?>
</body>
</html>