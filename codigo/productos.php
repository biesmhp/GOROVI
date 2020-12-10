<?php
require_once "funciones.php";
    if (isset($_POST["añadir"])) {
        $producto=$_POST["oculto"];
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
    
    <table border="1">
        <thead>Productos</thead>
        <th>Imagen</th><th>Nombre</th><th>Categoria</th><th>Precio</th>
        <?php foreach(getProductos() as $producto) :?>
            <tr>
                <td>
                    <img src="<?= $producto["nombre"] ?>" alt="<?= $producto["imagen"] ?>">
                </td>
                <td>
                    <?= $producto["nombre"] ?>
                </td>
                <td>
                    <?= $producto["categoria"] ?>
                </td>
                <td>
                    <?= $producto["precio"] ?>
                </td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="oculto" value="<?=$producto["id"]?>">
                        <input type="submit" name="añadir" value="Añadir a la cesta">
                    </form>
                </td>
            </tr>
        <?php endforeach ;?>
    </table>
</body>
</html>