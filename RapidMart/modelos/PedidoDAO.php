<?php 
require_once "Pedido.php";
require_once 'modelos/Sesion.php';

class PedidoDAO{

    private mysqli $conn;

    public function __construct($conn){
        $this->conn=$conn;
    }

    

    public function insert(): int|bool {
        $connexionDB = new ConnexionDB('alumno', '', 'localhost', 'market');
        $conn = $connexionDB->getConnexion();
        $productosDAO = new ProductosDAO($conn);
    
        $carritoDAO = new CarritoDAO($conn);
        $carrito = $carritoDAO->getById(Sesion::getUsuario()->getId());
    
        $insertsSuccess = true;
    
        foreach ($carrito as $producto) {
            $productos = $productosDAO->getById($producto->getIdProducto());
    
            if($productos->getStock() <= 0){
                $error = "No hay stock del producto " . $productos->getNombre();
                guardarMensaje($error);
                header('location:map.php?accion=inicio');
                exit(); // Asegúrate de detener la ejecución después de redirigir
            } else {
                if (!$stmt = $conn->prepare("INSERT INTO pedido (idProducto, idUsuario, precio, idVendedor) VALUES (?, ?, ?, ?)")) {
                    $error = "Error al preparar la consulta insert: " . $conn->error;
                    guardarMensaje($error);
                    $insertsSuccess = false;
                    continue;  // Continúa con el siguiente producto en caso de error
                }
    
                $idProducto = $productos->getId();
                $idUsuario = Sesion::getUsuario()->getId();
                $precio = $productos->getPrecio();
                $idVendedor = $productos->getIdVendedor();
    
                $stmt->bind_param('iiii', $idProducto, $idUsuario, $precio, $idVendedor);
                if ($stmt->execute()) {
                    $insertId = $stmt->insert_id;
    
                    if (!$stmt2 = $conn->prepare("UPDATE productos SET stock=? WHERE id=?")) {
                        $error = "Error al preparar la consulta update: " . $conn->error;
                        guardarMensaje($error);
                        $insertsSuccess = false;
                        continue;  // Continúa con el siguiente producto en caso de error
                    }
                    
                    $stock = $productos->getStock() - 1;
                    $stmt2->bind_param('ii', $stock, $idProducto);
                    if (!$stmt2->execute()) {
                        $insertsSuccess = false;
                    }

                  
    
                    // Aquí estaba el problema, debes usar $idUsuario para actualizar el rol
                    if (!$stmt3 = $conn->prepare("UPDATE usuarios SET rol=? WHERE id=?")) {
                        $error = "Error al preparar la consulta update: " . $conn->error;
                        guardarMensaje($error);
                        $insertsSuccess = false;
                        continue;  // Continúa con el siguiente producto en caso de error
                    }
                    
    
                    $rolUsu = Sesion::getUsuario()->getRol();
                    $rol = "Cliente," . $rolUsu;
                   
                    guardarMensaje($rol);
                    $stmt3->bind_param('si', $rol, $idUsuario);
                    if (!$stmt3->execute()) {
                        $insertsSuccess = false;
                    }
    
                    // Borrar producto del carrito después de insertar el pedido
                    if (!$stmt4 = $conn->prepare("DELETE FROM carrito WHERE idUsuario = ? AND idProducto = ?")) {
                        $error = "Error al preparar la consulta delete: " . $conn->error;
                        guardarMensaje($error);
                        $insertsSuccess = false;
                        continue;  // Continúa con el siguiente producto en caso de error
                    }
                    $stmt4->bind_param('ii', $idUsuario, $idProducto);
                    if (!$stmt4->execute()) {
                        $insertsSuccess = false;
                    }
    
                } else {
                    $insertsSuccess = false;
                }
            }
        }
    
        return $insertsSuccess;
    }

  

        public function getAllById($id) : array {
            // Utilizamos una consulta preparada para evitar inyección SQL
            if ($stmt = $this->conn->prepare("SELECT * FROM pedido WHERE idVendedor = ?")) {
                // Vinculamos el parámetro
                $stmt->bind_param("i", $id);
                
                // Ejecutamos la consulta
                if (!$stmt->execute()) {
                    echo "Error al ejecutar la consulta: " . $stmt->error;
                }
        
                // Obtenemos el resultado
                $result = $stmt->get_result();
        
                // Creamos un array para almacenar los productos
                $array_pedidos = array();
                while ($pedido = $result->fetch_object(Pedido::class)) {
                    $array_pedidos[] = $pedido;
                }
        
                // Cerramos la consulta
                $stmt->close();
        
                // Devolvemos el array de pedidos
                return $array_pedidos;
            } else {
                // En caso de error en la preparación de la consulta
                echo "Error en la preparación de la consulta: " . $this->conn->error;
                guardarMensaje('non');
                return array();
            }
        }


        public function getById($id) : Pedido|null{
            $query="SELECT * FROM pedido WHERE id= $id";
            $resultado=$this->conn->query($query);
    
            if($resultado->num_rows>0){
                $producto = $resultado->fetch_object(Pedido::class);
                
                return $producto;
            } else {
                return null;
            }
            }

}    
    

        
       
           
            
            
        





?>