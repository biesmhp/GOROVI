<?php
    # Habilitar sesiones
    session_start();

    # Funcion para mostrar arrays más ordenados
    function print_r2($val){
        echo "<pre>";
        print_r($val);
        echo "</pre>";
    }
    ##################
        //Base de datos
    ##################

    // # Constantes para acceder a base de datos
    // define("HOST", "localhost");
    // define("USERNAME", "root");
    // define("PASSWORD", "");
    // define("DATABASE", "GOROVI");

    // # Función para conectar a la base de datos
    // # PDO
    // function getConexionPDO(){
    //     $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
    //     $conexion = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USERNAME,PASSWORD,$opciones);
    //     //unset($conexion);
    //     return $conexion;
    // }

    class BaseDatos
    {
        const LUGAR = "mysql:host=localhost;dbname=GOROVI";
        const USUARIO = 'root';
        const PASSWORD = '';

        private static $instance = null;

        private function __construct(){}

        public static function getInstance()
        {
            if (self::$instance == null)
                # Si no está ya creado
                self::$instance = new BaseDatos();
            return self::$instance;
        }

        private function getConexion()
        {
            $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
            $conexion = new PDO(self::LUGAR,self::USUARIO,self::PASSWORD,$opciones);
            return $conexion;
        }

        ##################################################################################
            //FUNCIONES DE USUARIOS
        ############################################################

        # Obtener todos los usuarios
        # 
        public function getUsuarios(){
            $pdo=self::getConexion();
            $sql="SELECT * FROM Usuarios";
            $consulta=$pdo->query($sql);
            $usuarios=$consulta->fetchAll(PDO::FETCH_ASSOC);
            return $usuarios;
        }

        public function getUsuario($usuario){
            $pdo=self::getConexion();
            $sql="SELECT * FROM Usuarios WHERE usuario=?";
            $consulta=$pdo->prepare($sql);
            $consulta->execute([$usuario]);
            $resultado=$consulta->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

        # Añadir un usuario (imagen y rol por defecto)
        # 
        public function addUsuario($usuario,$contraseña,$nombre,$apellidos,$email){
            # Valores por defecto
            $imagen="imagen.png";
            $rol="cliente";
            $pdo=self::getConexion();
            $sql="INSERT INTO Usuarios(usuario,contraseña,nombre,apellidos,email,imagen,rol) VALUES (?,?,?,?,?,?,?)";
            $consulta=$pdo->prepare($sql);
            $consulta->execute([$usuario,$contraseña,$nombre,$apellidos,$email,$imagen,$rol]);
            $count = $consulta->rowCount();
            return $count;
        }

        # Borrar un usuario
        # 
        public function delUsuario($usuario){
            $pdo=self::getConexion();
            $sql="DELETE FROM Usuarios WHERE usuario=?";
            $consulta=$pdo->prepare($sql);
            $consulta->execute([$usuario]);
            $count = $consulta->rowCount();
            return $count;
        }

        # Actualizar datos de un usuario
        #
        public function updateUsuario($id,$usuario,$nombre,$apellidos,$email){
            $pdo=self::getConexion();
            $sql="UPDATE Usuarios SET usuario=?,nombre=?,apellidos=?,email=? WHERE id=?";
            $consulta=$pdo->prepare($sql);
            $consulta->execute([$usuario,$nombre,$apellidos,$email,$id]);
            $count = $consulta->rowCount();
            return $count;
        }

        # Actualizar datos de un usuario
        #
        public function updatePassUsuario($id,$contraseña){
            $pdo=self::getConexion();
            $sql="UPDATE Usuarios SET contraseña=? WHERE id=?";
            $consulta=$pdo->prepare($sql);
            $consulta->execute([$contraseña,$id]);
            $count = $consulta->rowCount();
            return $count;
        }

        # Resetear por completo la tabla usuarios
        # MUY PELIGROSO, se pierden todos los datos
        public function eraseUsuarios(){
            $pdo=self::getConexion();
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
        public function logUsuario($usuario,$contraseña){
            $pdo=self::getConexion();
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
        public function upgradeUsuario($usuario){
            $pdo=self::getConexion();
            $sql="UPDATE Usuarios SET rol='administrador' WHERE usuario=?";
            $consulta=$pdo->prepare($sql);
            $consulta->execute([$usuario]);
            $count = $consulta->rowCount();
            return $count;
        }

        # Quitar rol de administrador a un usuario
        #
        public function downgradeUsuario($usuario){
            $pdo=self::getConexion();
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
        public function getProductos(){
            $pdo=self::getConexion();
            $sql="SELECT * FROM Productos ORDER BY nombre";
            $consulta=$pdo->query($sql);
            $productos=$consulta->fetchAll(PDO::FETCH_ASSOC);
            return $productos;
        }

        # Obtener todos los productos filtrados por nombre
        # 
        public function getProductosFiltroNombre($nombre){
            $pdo=self::getConexion();
            $sql="SELECT * FROM Productos WHERE nombre LIKE ? ORDER BY categoria";
            $consulta=$pdo->prepare($sql);
            $consulta->execute([$nombre]);
            $resultado=$consulta->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        }

        # Obtener todos los productos filtrados por categoria
        # 
        public function getProductosFiltroCategoria($categoria){
            $pdo=self::getConexion();
            $sql="SELECT * FROM Productos WHERE categoria=? ORDER BY nombre";
            $consulta=$pdo->prepare($sql);
            $consulta->execute([$categoria]);
            $resultado=$consulta->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

        # Obtener un usuario
        # 
        public function getProducto($id){
            $pdo=self::getConexion();
            $sql="SELECT * FROM Productos WHERE id=?";
            $consulta=$pdo->prepare($sql);
            $consulta->execute([$id]);
            $resultado=$consulta->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

        # Añadir un producto (la imagen por defecto sera la de categoria, el stock 0 y la descripcion vacia)
        # 
        public function addProducto($nombre,$categoria,$precio){
            # Valores por defecto
            $descripcion="Sin descripción. ";
            $imagen="imagen.png";
            $stock="0";
            $pdo=self::getConexion();
            $sql="INSERT INTO Productos(nombre,descripcion,categoria,imagen,precio,stock) VALUES (?,?,?,?,?,?)";
            $consulta=$pdo->prepare($sql);
            $consulta->execute([$nombre,$descripcion,$categoria,$imagen,$precio,$stock]);
            $count = $consulta->rowCount();
            return $count;
        }

        # Borrar un usuario
        # 
        public function delProducto($id){
            $pdo=self::getConexion();
            $sql="DELETE FROM Productos WHERE id=?";
            $consulta=$pdo->prepare($sql);
            $consulta->execute([$id]);
            $count = $consulta->rowCount();
            return $count;
        }

        # Actualizar datos de un usuario
        #
        public function updateProducto($id,$usuario,$contraseña,$nombre,$apellidos,$email){
            $pdo=self::getConexion();
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
        public function getCategorias(){
            $pdo=self::getConexion();
            $sql="SELECT * FROM Categorias";
            $consulta=$pdo->query($sql);
            $categorias=$consulta->fetchAll(PDO::FETCH_ASSOC);
            return $categorias;
        }

        # Añadir una categoria (tendrá una imagen por defecto)
        # 
        public function addCategoria($categoria){
            # Valores por defecto
            $imagen="imagen.png";
            $pdo=self::getConexion();
            $sql="INSERT INTO Categorias(nombre,imagen) VALUES (?,?)";
            $consulta=$pdo->prepare($sql);
            $consulta->execute([$categoria,$imagen]);
            $count = $consulta->rowCount();
            return $count;
        }

        # Borrar una categoria
        # 
        public function delCategoria($categoriaID){
            $pdo=self::getConexion();
            $sql="DELETE FROM Categorias WHERE id=?";
            $consulta=$pdo->prepare($sql);
            $consulta->execute([$categoriaID]);
            $count = $consulta->rowCount();
            return $count;
        }
    }
    

    ##################################################################################
        //FUNCIONES DE USUARIOS
    ############################################################

    // # Obtener todos los usuarios
    // # 
    // function getUsuarios(){
    //     $pdo=getConexionPDO();
    //     $sql="SELECT * FROM Usuarios";
    //     $consulta=$pdo->query($sql);
    //     $usuarios=$consulta->fetchAll(PDO::FETCH_ASSOC);
    //     return $usuarios;
    // }

    // # Obtener un usuario
    // # 
    // function getUsuario($usuario){
    //     $pdo=getConexionPDO();
    //     $sql="SELECT * FROM Usuarios WHERE usuario=?";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute([$usuario]);
    //     $resultado=$consulta->fetch(PDO::FETCH_ASSOC);
    //     return $resultado;
    // }

    // # Añadir un usuario (imagen y rol por defecto)
    // # 
    // function addUsuario($usuario,$contraseña,$nombre,$apellidos,$email){
    //     # Valores por defecto
    //     $imagen="imagen.png";
    //     $rol="cliente";
    //     $pdo=getConexionPDO();
    //     $sql="INSERT INTO Usuarios(usuario,contraseña,nombre,apellidos,email,imagen,rol) VALUES (?,?,?,?,?,?,?)";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute([$usuario,$contraseña,$nombre,$apellidos,$email,$imagen,$rol]);
    //     $count = $consulta->rowCount();
    //     return $count;
    // }

    // # Borrar un usuario
    // # 
    // function delUsuario($usuario){
    //     $pdo=getConexionPDO();
    //     $sql="DELETE FROM Usuarios WHERE usuario=?";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute([$usuario]);
    //     $count = $consulta->rowCount();
    //     return $count;
    // }

    // # Actualizar datos de un usuario
    // #
    // function updateUsuario($id,$usuario,$nombre,$apellidos,$email){
    //     $pdo=getConexionPDO();
    //     $sql="UPDATE Usuarios SET usuario=?,nombre=?,apellidos=?,email=? WHERE id=?";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute([$usuario,$nombre,$apellidos,$email,$id]);
    //     $count = $consulta->rowCount();
    //     return $count;
    // }

    // # Actualizar datos de un usuario
    // #
    // function updatePassUsuario($id,$contraseña){
    //     $pdo=getConexionPDO();
    //     $sql="UPDATE Usuarios SET contraseña=? WHERE id=?";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute([$contraseña,$id]);
    //     $count = $consulta->rowCount();
    //     return $count;
    // }

    // # Resetear por completo la tabla usuarios
    // # MUY PELIGROSO, se pierden todos los datos
    // function eraseUsuarios(){
    //     $pdo=getConexionPDO();
    //     $sql="TRUNCATE TABLE Usuarios";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute();
    //     $count = $consulta->rowCount();
    //     return $count;
    // }

    ##################################################################################
        //FUNCIONES DE ACCESOS
    ############################################################

    // # Verificar usuario
    // #
    // function logUsuario($usuario,$contraseña){
    //     $pdo=getConexionPDO();
    //     $sql="SELECT contraseña FROM Usuarios WHERE usuario=?";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute([$usuario]);
    //     $resultado=$consulta->fetchColumn();
    //     if ($resultado==$contraseña) {
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

    // # Dar rol de administrador a un usuario
    // #
    // function upgradeUsuario($usuario){
    //     $pdo=getConexionPDO();
    //     $sql="UPDATE Usuarios SET rol='administrador' WHERE usuario=?";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute([$usuario]);
    //     $count = $consulta->rowCount();
    //     return $count;
    // }

    // # Quitar rol de administrador a un usuario
    // #
    // function downgradeUsuario($usuario){
    //     $pdo=getConexionPDO();
    //     $sql="UPDATE Usuarios SET rol='cliente' WHERE usuario=?";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute([$usuario]);
    //     $count = $consulta->rowCount();
    //     return $count;
    // }

    // ##################################################################################
    //     //FUNCIONES DE PRODUCTOS
    // ############################################################

    // # Obtener todos los productos
    // # 
    // function getProductos(){
    //     $pdo=getConexionPDO();
    //     $sql="SELECT * FROM Productos ORDER BY nombre";
    //     $consulta=$pdo->query($sql);
    //     $productos=$consulta->fetchAll(PDO::FETCH_ASSOC);
    //     return $productos;
    // }

    // # Obtener todos los productos filtrados por nombre
    // # 
    // function getProductosFiltroNombre($nombre){
    //     $pdo=getConexionPDO();
    //     $sql="SELECT * FROM Productos WHERE nombre LIKE ? ORDER BY categoria";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute([$nombre]);
    //     $resultado=$consulta->fetchAll(PDO::FETCH_ASSOC);
    //     return $resultado;
    // }

    // # Obtener todos los productos filtrados por categoria
    // # 
    // function getProductosFiltroCategoria($categoria){
    //     $pdo=getConexionPDO();
    //     $sql="SELECT * FROM Productos WHERE categoria=? ORDER BY nombre";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute([$categoria]);
    //     $resultado=$consulta->fetch(PDO::FETCH_ASSOC);
    //     return $resultado;
    // }

    // # Obtener un usuario
    // # 
    // function getProducto($id){
    //     $pdo=getConexionPDO();
    //     $sql="SELECT * FROM Productos WHERE id=?";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute([$id]);
    //     $resultado=$consulta->fetch(PDO::FETCH_ASSOC);
    //     return $resultado;
    // }

    // # Añadir un producto (la imagen por defecto sera la de categoria, el stock 0 y la descripcion vacia)
    // # 
    // function addProducto($nombre,$categoria,$precio){
    //     # Valores por defecto
    //     $descripcion="Sin descripción. ";
    //     $imagen="imagen.png";
    //     $stock="0";
    //     $pdo=getConexionPDO();
    //     $sql="INSERT INTO Productos(nombre,descripcion,categoria,imagen,precio,stock) VALUES (?,?,?,?,?,?)";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute([$nombre,$descripcion,$categoria,$imagen,$precio,$stock]);
    //     $count = $consulta->rowCount();
    //     return $count;
    // }

    // # Borrar un usuario
    // # 
    // function delProducto($id){
    //     $pdo=getConexionPDO();
    //     $sql="DELETE FROM Productos WHERE id=?";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute([$id]);
    //     $count = $consulta->rowCount();
    //     return $count;
    // }

    // # Actualizar datos de un usuario
    // #
    // function updateProducto($id,$usuario,$contraseña,$nombre,$apellidos,$email){
    //     $pdo=getConexionPDO();
    //     $sql="UPDATE Usuarios SET usuario=?,contraseña=?,nombre=?,apellidos=?,email=? WHERE id=?";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute([$usuario,$contraseña,$nombre,$apellidos,$email,$id]);
    //     $count = $consulta->rowCount();
    //     return $count;
    // }

    ##################################################################################
        //FUNCIONES DE CATEGORIAS
    ############################################################

    // # Obtener todos las Categorias
    // # 
    // function getCategorias(){
    //     $pdo=getConexionPDO();
    //     $sql="SELECT * FROM Categorias";
    //     $consulta=$pdo->query($sql);
    //     $categorias=$consulta->fetchAll(PDO::FETCH_ASSOC);
    //     return $categorias;
    // }

    // # Añadir una categoria (tendrá una imagen por defecto)
    // # 
    // function addCategoria($categoria){
    //     # Valores por defecto
    //     $imagen="imagen.png";
    //     $pdo=getConexionPDO();
    //     $sql="INSERT INTO Categorias(nombre,imagen) VALUES (?,?)";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute([$categoria,$imagen]);
    //     $count = $consulta->rowCount();
    //     return $count;
    // }

    // # Borrar una categoria
    // # 
    // function delCategoria($categoriaID){
    //     $pdo=getConexionPDO();
    //     $sql="DELETE FROM Categorias WHERE id=?";
    //     $consulta=$pdo->prepare($sql);
    //     $consulta->execute([$categoriaID]);
    //     $count = $consulta->rowCount();
    //     return $count;
    // }
?>