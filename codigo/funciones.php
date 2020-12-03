<?php
    # Habilitar sesiones
    session_start();

    ##################
        //Generales
    ##################

    # Constantes para acceder a base de datos
    define("HOST", "localhost");
    define("USERNAME", "root");
    define("PASSWORD", "");
    define("DATABASE", "GOROVI");

    # Funcion para mostrar arrays más ordenados
    function print_r2($val){
        echo "<pre>";
        print_r($val);
        echo "</pre>";
    }

    # Función para conectar a la base de datos
    # PDO
    function getConexionPDO(){
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $conexion = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USERNAME,PASSWORD,$opciones);
        //unset($conexion);
        return $conexion;
    }

    ##################################################################################
        //FUNCIONES DE USUARIOS
    ############################################################

    # Obtener todos los usuarios
    # 
    function getUsuarios(){
        $pdo=getConexionPDO();
        $sql="SELECT * FROM Usuarios";
        $consulta=$pdo->query($sql);
        $usuarios=$consulta->fetchAll(PDO::FETCH_ASSOC);
        return $usuarios;
    }

    # Obtener un usuario
    # 
    function getUsuario($usuario){
        $pdo=getConexionPDO();
        $sql="SELECT * FROM Usuarios WHERE usuario=?";
        $consulta=$pdo->prepare($sql);
        $consulta->execute([$usuario]);
        $resultado=$consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    # Añadir un usuario (imagen y rol por defecto)
    # 
    function addUsuario($usuario,$contraseña,$nombre,$apellidos,$email){
        # Valores por defecto
        $imagen="imagen.png";
        $rol="cliente";
        $pdo=getConexionPDO();
        $sql="INSERT INTO Usuarios(usuario,contraseña,nombre,apellidos,email,imagen,rol) VALUES (?,?,?,?,?,?,?)";
        $consulta=$pdo->prepare($sql);
        $consulta->execute([$usuario,$contraseña,$nombre,$apellidos,$email,$imagen,$rol]);
        $count = $consulta->rowCount();
        return $count;
    }

    # Borrar un usuario
    # 
    function delUsuario($usuario){
        $pdo=getConexionPDO();
        $sql="DELETE FROM Usuarios WHERE usuario=?";
        $consulta=$pdo->prepare($sql);
        $consulta->execute([$usuario]);
        $count = $consulta->rowCount();
        return $count;
    }

    # Actualizar datos de un usuario
    #
    function updateUsuario($id,$usuario,$nombre,$apellidos,$email){
        $pdo=getConexionPDO();
        $sql="UPDATE Usuarios SET usuario=?,nombre=?,apellidos=?,email=? WHERE id=?";
        $consulta=$pdo->prepare($sql);
        $consulta->execute([$usuario,$nombre,$apellidos,$email,$id]);
        $count = $consulta->rowCount();
        return $count;
    }

    # Resetear por completo la tabla usuarios
    # MUY PELIGROSO, se pierden todos los datos
    function eraseUsuarios(){
        $pdo=getConexionPDO();
        $sql="TRUNCATE TABLE Usuarios";
        $consulta=$pdo->prepare($sql);
        $consulta->execute();
        $count = $consulta->rowCount();
        return $count;
    }

    ##################################################################################
        //FUNCIONES DE ACCESOS
    ############################################################

    # Verificar usuario
    #
    function logUsuario($usuario,$contraseña){
        $pdo=getConexionPDO();
        $sql="SELECT contraseña FROM Usuarios WHERE usuario=?";
        $consulta=$pdo->prepare($sql);
        $consulta->execute([$usuario]);
        $resultado=$consulta->fetchColumn();
        if ($resultado==$contraseña) {
            return true;
        }else{
            return false;
        }
    }

    # Dar rol de administrador a un usuario
    #
    function upgradeUsuario($usuario){
        $pdo=getConexionPDO();
        $sql="UPDATE Usuarios SET rol='administrador' WHERE usuario=?";
        $consulta=$pdo->prepare($sql);
        $consulta->execute([$usuario]);
        $count = $consulta->rowCount();
        return $count;
    }

    # Quitar rol de administrador a un usuario
    #
    function downgradeUsuario($usuario){
        $pdo=getConexionPDO();
        $sql="UPDATE Usuarios SET rol='cliente' WHERE usuario=?";
        $consulta=$pdo->prepare($sql);
        $consulta->execute([$usuario]);
        $count = $consulta->rowCount();
        return $count;
    }

    ##################################################################################
        //FUNCIONES DE PRODUCTOS
    ############################################################

    # Obtener todos los productos
    # 
    function getProductos(){
        $pdo=getConexionPDO();
        $sql="SELECT * FROM Productos ORDER BY nombre";
        $consulta=$pdo->query($sql);
        $productos=$consulta->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    }

    # Obtener todos los productos filtrados por nombre
    # 
    function getProductosFiltroNombre($nombre){
        $pdo=getConexionPDO();
        $sql="SELECT * FROM Productos WHERE nombre=? ORDER BY categoria";
        $consulta=$pdo->prepare($sql);
        $consulta->execute([$nombre]);
        $resultado=$consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    # Obtener todos los productos filtrados por categoria
    # 
    function getProductosFiltroCategoria($categoria){
        $pdo=getConexionPDO();
        $sql="SELECT * FROM Productos WHERE categoria=? ORDER BY nombre";
        $consulta=$pdo->prepare($sql);
        $consulta->execute([$categoria]);
        $resultado=$consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    # Obtener un usuario
    # 
    function getProducto($usuario){
        $pdo=getConexionPDO();
        $sql="SELECT * FROM Usuarios WHERE usuario=?";
        $consulta=$pdo->prepare($sql);
        $consulta->execute([$usuario]);
        $resultado=$consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    # Añadir un producto (la imagen por defecto sera la de categoria, el stock 0 y la descripcion vacia)
    # 
    function addProducto($nombre,$categoria,$precio){
        # Valores por defecto
        $descripcion="Sin descripción. ";
        $imagen="imagen.png";
        $stock="0";
        $pdo=getConexionPDO();
        $sql="INSERT INTO Productos(nombre,descripcion,categoria,imagen,precio,stock) VALUES (?,?,?,?,?,?)";
        $consulta=$pdo->prepare($sql);
        $consulta->execute([$nombre,$descripcion,$categoria,$imagen,$precio,$stock]);
        $count = $consulta->rowCount();
        return $count;
    }

    # Borrar un usuario
    # 
    function delProducto($id){
        $pdo=getConexionPDO();
        $sql="DELETE FROM Productos WHERE id=?";
        $consulta=$pdo->prepare($sql);
        $consulta->execute([$id]);
        $count = $consulta->rowCount();
        return $count;
    }

    # Actualizar datos de un usuario
    #
    function updateProducto($id,$usuario,$contraseña,$nombre,$apellidos,$email){
        $pdo=getConexionPDO();
        $sql="UPDATE Usuarios SET usuario=?,contraseña=?,nombre=?,apellidos=?,email=? WHERE id=?";
        $consulta=$pdo->prepare($sql);
        $consulta->execute([$usuario,$contraseña,$nombre,$apellidos,$email,$id]);
        $count = $consulta->rowCount();
        return $count;
    }

    ##################################################################################
        //FUNCIONES DE CATEGORIAS
    ############################################################

    # Obtener todos las Categorias
    # 
    function getCategorias(){
        $pdo=getConexionPDO();
        $sql="SELECT * FROM Categorias";
        $consulta=$pdo->query($sql);
        $categorias=$consulta->fetchAll(PDO::FETCH_ASSOC);
        return $categorias;
    }

    # Añadir una categoria (tendrá una imagen por defecto)
    # 
    function addCategoria($categoria){
        # Valores por defecto
        $imagen="imagen.png";
        $pdo=getConexionPDO();
        $sql="INSERT INTO Categorias(nombre,imagen) VALUES (?,?)";
        $consulta=$pdo->prepare($sql);
        $consulta->execute([$categoria,$imagen]);
        $count = $consulta->rowCount();
        return $count;
    }

    # Borrar una categoria
    # 
    function delCategoria($categoriaID){
        $pdo=getConexionPDO();
        $sql="DELETE FROM Categorias WHERE id=?";
        $consulta=$pdo->prepare($sql);
        $consulta->execute([$categoriaID]);
        $count = $consulta->rowCount();
        return $count;
    }
?>