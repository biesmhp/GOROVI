<?php
require_once "funciones.php";
    
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
    <?php print_r2(getProductos()); ?>
</body>
</html>