<?php
require_once "funciones.php";
    if (isset($_POST["añadirCategoria"])) {
        $categoria = $_POST["categoria"];
        if ($categoria!=null) {
            addCategoria($categoria);
        }
    }
    if (isset($_POST["borrarCategoria"])) {
        $categoria = $_POST["categoria"];
        delCategoria($categoria);
    }
    if (isset($_POST["añadirProducto"])) {
        $nombre=$_POST["nombre"];
        $categoria=$_POST["categoria"];
        $precio=$_POST["precio"];
        print(addProducto($nombre,$categoria,$precio));
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almacen</title>
</head>
<body>
    <nav>
        <a href="portada.php">Inicio</a>
    </nav>
    <!--Muestra todos los usuarios y sus campos-->
    <?php if(isset($_POST["ver"])){print_r2(getProductos());}?>
    <form action="" method="POST">
        <input type="submit" name="ver" value="Ver todos los productos">
    </form>
    <!--Buscar producto-->
        <form action="" method="POST">
            <fieldset>
                <legend>Buscar producto</legend>
                <input type="text" name="busqueda" placeholder="producto" required>
                <input type="submit" name="buscar" value="Buscar">
            </fieldset>
        </form>
            <?php 
                if (isset($_POST["buscar"])) {
                    $busqueda = "%".$_POST["busqueda"]."%";
                    print_r2(getProductosFiltroNombre($busqueda));
                }
            ?>
    <!--Añadir producto-->
    <form action="" method="POST">
        <fieldset>
            <legend>Añadir producto</legend>
            <input type="text" name="nombre" placeholder="nombre" required><br>
            <select name="categoria">
                <?php foreach(getCategorias() as $categoria) :?>
                    <option value="<?=$categoria["id"]?>"><?=$categoria["nombre"]?></option>
                <?php endforeach ;?>
            </select><br>
            <input type="number" step=".01" name="precio" min="1" placeholder="precio" required><br>
            <input type="submit" name="añadirProducto" value="Añadir producto">
        </fieldset>
    </form>
    <!--Añadir categoria-->
    <form action="" method="POST">
        <fieldset>
            <legend>Añadir categoria</legend>
            <input type="text" name="categoria" placeholder="categoria">
            <input type="submit" name="añadirCategoria" value="Añadir">
        </fieldset>
    </form>
    <!--Borrar categoria-->
    <form action="" method="POST">
        <fieldset>
            <legend>Eliminar categoria</legend>
            <select name="categoria">
                <?php foreach(getCategorias() as $categoria) :?>
                    <option value="<?=$categoria["id"]?>"><?=$categoria["nombre"]?></option>
                <?php endforeach ;?>
            </select>
            <input type="submit" name="borrarCategoria" value="Eliminar">
        </fieldset>
    </form>
    <!--Otra-->
</body>
</html>