<?php
require_once "funciones.php";
$instance = BaseDatos::getInstance();
if (isset($_POST["añadir"])) {
    $producto = $_POST["oculto"];
    $_SESSION["cesta"][] = $instance::getProducto($producto);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="estilos.css">
    <title>Productos</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <a class="navbar-brand px-5 volver" href="portada.php">Inicio</a>
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
            <a class="navbar-brand px-5 volver" href="cesta.php">Cesta</a>
        <?php endif; ?>
    </nav>

    <div class="container" id="main">
        <div class="row mx-0 mt-5">
            <?php foreach ($instance::getProductos() as $producto) : ?>
                <div class="col-12 col-lg-3 m-0 d-flex py-2">
                    <div class="w-100 h-100 d-flex flex-column fondo-producto shadow border rounded">
                        <div class="row mx-0 no-gutters w-100">
                            <h3 class="text-center nombre-producto"> <?= $producto["nombre"] ?> </h3>
                        </div>
                        <div class="row mx-0 no-gutters d-flex flex-column w-100">
                            <img src="homer.jpg" alt="" class="img-fluid row mx-0 no-gutters">
                            <div class="row mx-0 d-flex flex-row mx-0 no-gutters py-2">
                                <div class="col-12 col-lg-6 justify-content-center align-items-center d-flex text-truncate">Categoría: <?= $producto["categoria"] ?></div>
                                <div class="col-12 col-lg-6 justify-content-center align-items-center d-flex text-truncate">Precio: <?= $producto["precio"] ?>€</div>
                            </div>
                            <div class="row mx-0 justify-content-center align-items-center d-flex py-2">
                                <?php if (isset($_SESSION["usuario"])) : ?>
                                    <form action="" method="POST" class="d-flex justify-content-center align-items-center">
                                        <input type="hidden" name="oculto" value="<?= $producto["id"] ?>">
                                        <input type="submit" name="añadir" value="Añadir a la cesta" class="btn btn-primary botones" type="button">
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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
<!-- <img src="<?= $producto["nombre"] ?>" alt="<?= $producto["imagen"] ?>" class="img-responsive">-->