<?php 

        require_once 'modelos/ConnexionDB.php';
        require_once 'modelos/Usuarios.php';
        require_once 'modelos/UsuariosDAO.php';
        require_once 'modelos/ProductosDAO.php';
        require_once 'modelos/TareasDAO.php';
        require_once 'config/config.php';
        require_once 'modelos/CarritoDAO.php';
        require_once 'modelos/PedidoDAO.php';

class ControladorTienda{
    public function inicio(){

        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        //Creamos el objeto TareasDAO para acceder a BBDD a través de este objeto
        $productos=array();
        $productosDAO = new ProductosDAO($conn);
        
       
        //Incluyo la vista
        require 'index.php';
    }

    
    public function insertar() {
        $error = '';
    
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
    
        $usuarioDAO = new UsuariosDAO($conn);
        $productosDAO = new ProductosDAO($conn);
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = htmlspecialchars($_POST['nombre']);
            $descripcion = htmlspecialchars($_POST['descripcion']);
            $foto = "";
            $precio = htmlspecialchars($_POST['precio']);
            $stock = htmlspecialchars($_POST['stock']);
            $categoria = htmlspecialchars($_POST['categoria']);
            $especificaciones = htmlspecialchars($_POST['especificaciones']);
    
            if (empty($nombre) || empty($descripcion) || empty($precio) || empty($categoria) || empty($especificaciones)) {
                $error = "Todos los campos son obligatorios";
            } else if ($_FILES['foto']['type'] != 'image/jpeg' && $_FILES['foto']['type'] != 'image/webp' && $_FILES['foto']['type'] != 'image/png') {
                $error = "La foto no tiene el formato adecuado";
            } else {
                $foto = $usuarioDAO->generarNombreArchivo($_FILES['foto']['name']);
                while (file_exists("fotoProductos/$foto")) {
                    $foto = $usuarioDAO->generarNombreArchivo($_FILES['foto']['name']);
                }
                
                if (!move_uploaded_file($_FILES['foto']['tmp_name'], "fotoProductos/$foto")) {
                    $error = "Error al copiar la foto a la carpeta fotoProductos";
                } else {
                    $productos = new Productos();
                    $productos->setNombre($nombre);
                    $productos->setDescripcion($descripcion);
                    $productos->setFoto($foto);
                    $productos->setPrecio($precio);
                    $productos->setStock($stock);
                    $productos->setCategoria($categoria);
                    $productos->setEspecificaciones($especificaciones);
                    $productos->setIdVendedor(Sesion::getUsuario()->getId());
    
                    $producto = $productosDAO->insert($productos);
    
                    echo json_encode([
                        'success' => true,
                        'id' => $productos->getId(),
                        'nombre' => $nombre,
                        'descripcion' => $descripcion,
                        'precio' => $precio,
                        'stock' => $stock,
                        'categoria' => $categoria,
                        'especificaciones' => $especificaciones,
                        'foto' => $foto
                    ]);
                    header('Location: map.php?accion=inicio');
                    exit;
                   
                }
            }
    
            if ($error) {
                echo json_encode([
                    'success' => false,
                    'message' => $error
                ]);
                exit;
            }
        }
        header('Location: map.php?accion=inicio');
    }
    
 
    

        public function addToCarrito(){

            $error ='';

            //Creamos la conexión utilizando la clase que hemos creado
            $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
            $conn = $connexionDB->getConnexion();
    
            $carritoDAO = new CarritoDAO($conn);
            
    
    
            if($_SERVER['REQUEST_METHOD']=='GET'){
    
                //Limpiamos los datos que vienen del usuario
                
                $idProducto=htmlspecialchars($_GET['id']);
               
        }
         // Crear el objeto Producto y establecer sus propiedades
         $carritos = new carrito();
         $carritos->setIdProducto($idProducto);
         $carritos->setIdUsuario(Sesion::getUsuario()->getId()); // El id del usuario conectado (en la sesión)
     
         // Insertar el producto en la base de datos
         $carrito = $carritoDAO->insert($carritos);
        // print $carrito->toJSON();
        // sleep(1);
        header('Location: vistas/producto.php?id=' . $idProducto);
        
    }

    public function verCarrito(){

        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        //Creamos el objeto TareasDAO para acceder a BBDD a través de este objeto
        $productos=array();
        $productosDAO = new ProductosDAO($conn);
        
       
        //Incluyo la vista
        require 'vistas/verCarrito.php';
    }

    public function verCompra(){

        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        //Creamos el objeto TareasDAO para acceder a BBDD a través de este objeto
        $productos=array();
        $productosDAO = new ProductosDAO($conn);
        
       
        //Incluyo la vista
        require 'vistas/comprar.php';
    }

    public function verCompraDirecta(){

        //Creamos la conexión utilizando la clase que hemos creado
        $error ='';

        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        $carritoDAO = new CarritoDAO($conn);
        


        if($_SERVER['REQUEST_METHOD']=='GET'){

            //Limpiamos los datos que vienen del usuario
            
            $idProducto=htmlspecialchars($_GET['id']);
           
    }
     // Crear el objeto Producto y establecer sus propiedades
     $carritos = new carrito();
     $carritos->setIdProducto($idProducto);
     $carritos->setIdUsuario(Sesion::getUsuario()->getId()); // El id del usuario conectado (en la sesión)
 
     // Insertar el producto en la base de datos
     $carrito = $carritoDAO->insert($carritos);
     $productos=array();
     $productosDAO = new ProductosDAO($conn);

        require 'vistas/comprar.php';
    }


    public function comprar(){

        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        $pedidoDAO = new PedidoDAO($conn);
    
     // Insertar el producto en la base de datos
     $carrito = $pedidoDAO->insert();
    // print $carrito->toJSON();
    // sleep(1);
    header('location:map.php?accion=inicio' );
    
}


    public function buscar(){

        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        $productosDAO = new ProductosDAO($conn);

        if($_SERVER['REQUEST_METHOD']=='POST'){
            $categoria = htmlspecialchars($_POST["buscar"]);
            $arrayfiltrar = Array();
            $arrayfiltrar = $productosDAO->getByCategoria($categoria);
            guardarMensaje("dfs");

            require 'index.php';
          }
    }


    public function misProductos(){

         //Creamos la conexión utilizando la clase que hemos creado
         $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
         $conn = $connexionDB->getConnexion();
 
         //Creamos el objeto TareasDAO para acceder a BBDD a través de este objeto
         $productos=array();
         $productosDAO = new ProductosDAO($conn);
         
        
         //Incluyo la vista
         require 'vistas/misProductos.php';

    }

    public function productoEditar() {
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
        $productosDAO = new ProductosDAO($conn);
        $idProducto = htmlspecialchars($_GET['id']);
        $producto = $productosDAO->getById($idProducto);
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = htmlspecialchars($_POST['nombre']);
            $descripcion = htmlspecialchars($_POST['descripcion']);
            $precio = htmlspecialchars($_POST['precio']);
            $stock = htmlspecialchars($_POST['stock']);
            $especificaciones = htmlspecialchars($_POST['especificaciones']);
            $producto->setNombre($nombre);
            $producto->setDescripcion($descripcion);
            $producto->setPrecio($precio);
            $producto->setStock($stock);
            $producto->setStock($especificaciones);
    
            if ($productosDAO->editar($producto)) {
                guardarMensaje("Producto actualizado correctamente");
            } else {
                
            }
    
            header('Location: map.php?accion=inicio');
            exit;
        }
        }


        public function resumenVentas(){

         //Creamos la conexión utilizando la clase que hemos creado
         $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
         $conn = $connexionDB->getConnexion();
 
         //Creamos el objeto TareasDAO para acceder a BBDD a través de este objeto
         $productos=array();
         $productosDAO = new ProductosDAO($conn);
         
        
         //Incluyo la vista
         require 'vistas/resumenVentas.php';

    }

       

}

   