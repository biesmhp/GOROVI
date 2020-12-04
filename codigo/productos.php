<?php
require_once "funciones.php";
    if (isset($_POST["añadirCesta"])) {
        $producto=$_POST["producto"];
        $_SESSION["cesta"][]=getProducto($producto);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>
<body>
    <nav>
        <a href="portada.php">Inicio</a>
    </nav>
    <form action="" method="POST">
        <select name="producto">
            <?php foreach(getProductos() as $productos) :?>
                <option value="<?=$productos["id"]?>"><?=$productos["nombre"]?></option>
            <?php endforeach ;?>
        </select>
        <input type="submit" name="añadirCesta" value="Añadir a la cesta">
    </form>
</body>
</html>