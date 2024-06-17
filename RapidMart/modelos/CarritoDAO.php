<?php 
require_once "Carrito.php";

class CarritoDAO{

    private mysqli $conn;

    public function __construct($conn){
        $this->conn=$conn;
    }

    public function insert($carrito): int|bool{
        if(!$stmt=$this->conn->prepare("INSERT INTO carrito (idProducto,idUsuario) VALUES (?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error);
        }
        $idProducto=$carrito->getIdProducto();
        $idUsuario=$carrito->getIdUsuario();

        $stmt->bind_param('ii',$idProducto,$idUsuario);
        if($stmt->execute()){
            return $stmt->insert_id;
        }else{
            return false;
        }
    }

    public function getById($idUsuario):array{
        if(!$stmt=$this->conn->prepare("SELECT * FROM carrito WHERE idUsuario = ?")){
            echo"Error en la SQL:".$this->conn->error;
        }
            $stmt->bind_param('i',$idUsuario);
            $stmt->execute();
            $result=$stmt->get_result();
            

            $array_carrito=array();
           while($carrito=$result->fetch_object(Carrito::class)){
            $array_carrito[]=$carrito;
           }
           return $array_carrito;

          
      } 


}