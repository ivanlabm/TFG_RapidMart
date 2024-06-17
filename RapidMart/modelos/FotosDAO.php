<?php 
class FotosDAO{

    private mysqli $conn;

    public function __construct($conn){
        $this->conn=$conn;
    }


    public function insert(int $idProducto ,array $fotos): bool{
        if(!$stmt = $this->conn->prepare("INSERT INTO fotosAnuncio (foto,idProducto) VALUES (?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
       
       foreach($fotos as $foto){
        $stmt->bind_param('si',$foto,$idProducto);
        $stmt->execute();
       }
        
        if($this->conn->affected_rows==count($fotos)){
            return true;
        }
        else{
            return false;
        }
    }

    
     public function getById($idProducto) : Foto|null{
        if(!$stmt=$this->conn->prepare("SELECT * FROM fotosAnuncio WHERE idProducto = ?")){
            echo"Error en la SQL:".$this->conn->error;
        }
            $stmt->bind_param('i',$idProducto);
            $stmt->execute();
            $result=$stmt->get_result();
            
            if($result->num_rows==1){
                $foto=$result->fetch_object(Foto::class);
                return $foto;
            }else{
                return null;
            }

          
      }  

      public function getFotosById($idProducto):array{
        if(!$stmt=$this->conn->prepare("SELECT * FROM productos WHERE id = ?")){
            echo"Error en la SQL:".$this->conn->error;
        }
            $stmt->bind_param('i',$idProducto);
            $stmt->execute();
            $result=$stmt->get_result();
            

            $array_fotos=array();
           while($foto=$result->fetch_object(Foto::class)){
            $array_fotos[]=$foto;
           }
           return $array_fotos;

          
      } 
    

      public function getAll():array{
        if(!$stmt= $this->conn->prepare("SELECT * FROM fotosAnuncio")){
            echo "Error en la SQL:".$this->conn->error;

        }
        $stmt->execute();
        $result=$stmt->get_result();

        $array_fotos=array();
        while($foto=$result->fetch_object(Foto::class)){
            $array_fotos[]=$foto;
        }
        return $array_fotos;
      }

      function delete($idProducto):bool{

        if(!$stmt = $this->conn->prepare("DELETE FROM anuncios WHERE idProducto = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$idProducto);
        //Ejecutamos la SQL
        $stmt->execute();
        //Comprobamos si ha borrado algún registro o no
        if($stmt->affected_rows==1){
            return true;
        }
        else{
            return false;
        }
        
    }

      
    
}



?>