<?php 
require_once "Productos.php";
require_once "ProductosDAO.php";

class ProductosDAO{

    private mysqli $conn;

    public function __construct($conn){
        $this->conn=$conn;
    }

    public function insert($producto): int|bool{
        if(!$stmt=$this->conn->prepare("INSERT INTO productos (nombre,descripcion,foto,precio,idVendedor,stock,categoria,especificaciones) VALUES (?,?,?,?,?,?,?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error);
        }
        $nombre=$producto->getNombre();
        $descripcion=$producto->getDescripcion();
        $foto=$producto->getFoto();
        $precio=$producto->getPrecio();
        $idVendedor=$producto->getIdVendedor();
        $categoria=$producto->getCategoria();
        $especificaciones=$producto->getEspecificaciones();
        $stock=$producto->getStock();

        $stmt->bind_param('sssdiiss',$nombre,$descripcion,$foto,$precio,$idVendedor,$stock,$categoria,$especificaciones);
        if($stmt->execute()){
            return $stmt->insert_id;
        }else{
            return false;
        }
    }

    public function getAll(): array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM productos")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        $stmt->execute();
        $result = $stmt->get_result();
    
        $array_productos = array();
        while ($producto = $result->fetch_object('Productos')) {
            $array_productos[] = $producto;
        }
        return $array_productos;
    }

    public function getById($id) : Productos|null{
        $query="SELECT * FROM productos WHERE id= $id";
        $resultado=$this->conn->query($query);

        if($resultado->num_rows>0){
            $producto = $resultado->fetch_object(Productos::class);
            
            return $producto;
        } else {
            return null;
        }
        }


        public function getByCategoria($categoria) : array {
            // Utilizamos una consulta preparada para evitar inyección SQL
            if ($stmt = $this->conn->prepare("SELECT * FROM productos WHERE categoria = ?")) {
                // Vinculamos el parámetro
                $stmt->bind_param("s", $categoria);
                
                // Ejecutamos la consulta
                if (!$stmt->execute()) {
                    echo "Error al ejecutar la consulta: " . $stmt->error;
                }
        
                // Obtenemos el resultado
                $result = $stmt->get_result();
        
                // Creamos un array para almacenar los productos
                $array_productos = array();
                while ($producto = $result->fetch_object(Productos::class)) {
                    $array_productos[] = $producto;
                }
        
                // Cerramos la consulta
                $stmt->close();
        
                // Devolvemos el array de productos
                return $array_productos;
            } else {
                // En caso de error en la preparación de la consulta
                echo "Error en la preparación de la consulta: " . $this->conn->error;
                return array();
            }
        }
        


        function update($producto){
            if(!$stmt = $this->conn->prepare("UPDATE productos SET stock=? WHERE id=?")){
                die("Error al preparar la consulta update: " . $this->conn->error );
            }
           

            $stock=$producto->getStock();
            $id = $producto->getId();
            $stmt->bind_param('ii',$stock,$id);
            return $stmt->execute();
        }



        public function getByUsuario($idVendedor) : array {
            // Utilizamos una consulta preparada para evitar inyección SQL
            if ($stmt = $this->conn->prepare("SELECT * FROM productos WHERE idVendedor = ?")) {
                // Vinculamos el parámetro
                $stmt->bind_param("i", $idVendedor);
                
                // Ejecutamos la consulta
                if (!$stmt->execute()) {
                    echo "Error al ejecutar la consulta: " . $stmt->error;
                }
        
                // Obtenemos el resultado
                $result = $stmt->get_result();
        
                // Creamos un array para almacenar los productos
                $array_productos = array();
                while ($producto = $result->fetch_object(Productos::class)) {
                    $array_productos[] = $producto;
                }
        
                // Cerramos la consulta
                $stmt->close();
        
                // Devolvemos el array de productos
                return $array_productos;
            } else {
                // En caso de error en la preparación de la consulta
                echo "Error en la preparación de la consulta: " . $this->conn->error;
                return array();
            }
        }

        function editar($producto) {
            if (!$stmt = $this->conn->prepare("UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?,especificaciones=? WHERE id=?")) {
                die("Error al preparar la consulta update: " . $this->conn->error);
            }
        
            $nombre = $producto->getNombre();
            $descripcion = $producto->getDescripcion();
            $precio = $producto->getPrecio();
            $stock = $producto->getStock();
            $especificaciones=$producto->getEspecificaciones();
            $id = $producto->getId();
           
               
        
            $stmt->bind_param('ssdisi', $nombre, $descripcion, $precio, $stock,$especificaciones, $id);
        
            $stmt->execute();
               
        }


    }







?>