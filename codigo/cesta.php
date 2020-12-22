<?php
require_once "funciones.php";

class CestaCompra
{
    ###Para su correcto funcionamniento los productos deben ser objetos (y no arrays)

    protected $productos = array();

    /**
     * * @param int ID Añade el producto con ese ID a la cesta
     */
    public function nuevoArticulo($codigo)
    {
        $producto = BaseDatos::getInstance()->getProducto($codigo);
        $this->productos[] = $producto;
    }

    public function getProductos()
    {
        return $this->productos;
    }

    public function getCoste()
    {
        $total = 0;
        foreach ($this->productos as $producto) {
            $total += $producto->precio;
        }
        return $total;
    }

    public function estaVacia()
    {
        if (count($this->productos) == 0)
            return true;
        return false;
    }

    public function guardarCesta()
    {
        $_SESSION["cesta"] = $this;
    }

    public static function cargarCesta()
    {
        if (!isset($_SESSION["cesta"])) {
            return new CestaCompra();
        } else {
            return ($_SESSION["cesta"]);
        }
    }
}

if (isset($_POST["quitar"])) {
    $idOculto = $_POST["oculto"];
    // print($idOculto);
    // print_r2($_SESSION["cesta"]);
}
if (isset($_POST["vaciar"])) {
    $_SESSION["cesta"] = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="estilos.css">
    <title>Carrito de la compra</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand px-5 volver" href="portada.php">Inicio</a>
        <a class="navbar-brand px-5 volver" href="productos.php">Productos</a>
        <?php if (!isset($_SESSION["usuario"])) : ?>
            <a class="navbar-brand px-5 volver" href="registro.php">Registrarse</a>
            <a class="navbar-brand px-5 volver" href="login.php">Iniciar sesión</a>
        <?php endif; ?>
        <?php if (isset($_SESSION["usuario"])) : ?>
            <a class="navbar-brand px-5 volver" href="perfil.php"><?= "Perfil de: " . $_SESSION["usuario"]["usuario"] ?></a>
            <?php if ($_SESSION["usuario"]["rol"] == "administrador") : ?>
                <a class="navbar-brand px-5 volver" href="admin.php">Administración</a>
                <a class="navbar-brand px-5 volver" href="almacen.php">Almacen</a>
            <?php endif; ?>
        <?php endif; ?>
    </nav>
    <div class="container" id="main">
        <div class="shadow col  mx-2 my-3 d-flex py-2 border border-secondary rounded fondo-producto text-center d-flex align-content-center justify-content-center">
            <?php if ($_SESSION["cesta"]) : ?>
                <table class="table">
                    <thead class="text-light bg-dark mt-0">
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Precio</th>
                            <th scope="col"></th>
                            <?php foreach ($_SESSION["cesta"] as $producto) : ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row"><?= $producto["nombre"] ?></th>
                            <td><?= $producto["categoria"] ?></td>
                            <td><?= $producto["precio"] ?>€</td>
                            <td>
                                <form action="" method="POST">
                                    <input type="hidden" name="oculto" value="<?= $producto["id"] ?>">
                                    <input class="btn btn-primary botones" type="submit" name="quitar" value="Quitar del carrito">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </tbody>
                </table>
            <?php else : ?>
                La cesta está vacía
            <?php endif; ?>

        </div>
        <div class="mt-5 text-center d-flex align-content-center justify-content-center">
            <form action="" method="POST">
                <label for="vaciar">Vaciar TODA la cesta</label>
                <input class="btn btn-primary botones" type="submit" name="vaciar" value="Vaciar">
            </form>
        </div>
    </div>

    <footer class="bg-light text-center text-lg-start mt-5">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
            Carlos Gómez - Brendan Rodríguez - Víctor Cuevas © 2020 Copyright:
            <a class="text-dark" href="portada.php">gorovi.com</a>
        </div>
        <!-- Copyright -->
    </footer>
    </div>
</body>

</html>