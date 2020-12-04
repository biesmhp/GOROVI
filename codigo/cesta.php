<?php 
require_once "funciones.php";
    if (isset($_POST["quitar"])) {
        $idOculto =$_POST["oculto"];
        print($idOculto);
        foreach ($_SESSION["cesta"] as $producto) {
            print_r2($producto);
            if ($producto["id"]==$idOculto) {
                $producto=null;
            }
        }
    }
    if (isset($_POST["vaciar"])) {
        $_SESSION["cesta"]=null;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de la compra</title>
</head>
<body>
    <nav>
        <a href="portada.php">Inicio</a>
    </nav>
    <?php if($_SESSION["cesta"]) :?>
    <table border="1">
        <thead>Cesta de la compra</thead>
        <th>Producto</th><th>Categoria</th><th>Precio</th>
        <?php foreach($_SESSION["cesta"] as $producto) :?>
            <tr>
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
                        <input type="submit" name="quitar" value="Quitar del carrito">
                    </form>
                </td>
            </tr>
        <?php endforeach ;?>
    </table>
    <?php else :?>
        La cesta está vacía
    <?php endif ;?>
    <form action="" method="POST">
        <fieldset>
            <legend>Vaciar TODA la cesta</legend>
            <input type="submit" name="vaciar" value="Vaciar toda la cesta">
        </fieldset>
    </form>
    <?php print_r2($_SESSION["cesta"]); ?>
</body>
</html>