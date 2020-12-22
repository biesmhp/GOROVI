<?php
require_once "funciones.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" media="screen">
    <!-- Compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Minified JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="estilos.css">
    <title>GOROVI</title>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark fixed-top">
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
            <a class="navbar-brand px-5 volver" href="cesta.php">Cesta</a>
        <?php endif; ?>
    </nav>

    <!-- GALERIA PARA LAS CATEGORÍAS Y HACERLAS ENLACE FILTRADO-->
    <div class="d-flex justify-content-center align-items-center" style="margin-top: 10%; margin-bottom:19%; height: 100%; width: 100%">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="fondo active"></li>
                <li data-target="#myCarousel" data-slide-to="1" class="fondo"></li>
                <li data-target="#myCarousel" data-slide-to="2" class="fondo"></li>
                <li data-target="#myCarousel" data-slide-to="3" class="fondo"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner d-flex justify-content-center align-items-center">
                <div class="item active">
                    <a href="productos.php">
                        <img src="camiseta.jpg" alt="" style="width:500px;height:300px">
                    </a>
                </div>
                <div class="item">
                    <a href="productos.php">
                        <img src="zapatos.jpg" alt="" style="width:500px;height:300px">
                    </a>
                </div>
                <div class="item">
                    <a href="productos.php">
                        <img src="pantalon.jpg" alt="" style="width:500px;height:300px">
                    </a>
                </div>
                <div class="item">
                    <a href="productos.php">
                        <img src="sombrero.jpg" alt="" style="width:500px;height:300px">
                    </a>
                </div>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    </div>
</body>
<footer class="bg-light text-center text-lg-start mt-5">
    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        Carlos Gómez - Brendan Rodríguez - Víctor Cuevas © 2020 Copyright:
        <a class="text-dark" href="portada.php">gorovi.com</a>
    </div>
    <!-- Copyright -->
</footer>

</html>