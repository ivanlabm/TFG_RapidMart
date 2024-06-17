<?php 
require_once "Usuarios.php";
require_once 'Sesion.php';
class UsuariosDAO{
    private mysqli $conn;

    public function __construct($conn){
        $this->conn=$conn;
    }
    
    public function getByCorreo($correo):Usuarios|null{
        if(!$stmt=$this->conn->prepare("SELECT * FROM usuarios WHERE correo=?")){
            echo"Error en la SQL(getByCorreo): ".$this->conn->error;
        }

        $stmt->bind_param('s',$correo);

        $stmt->execute();

        $result=$stmt->get_result();

        if($result->num_rows >= 1){
            $usuario = $result->fetch_object(Usuarios::class);
            return $usuario;
        }
        else{
            return null;
        }
    }
    public function getById($id):Usuarios|null {
        $query="SELECT * FROM usuarios WHERE id= $id";
        $resultado=$this->conn->query($query);

        if($resultado->num_rows>0){
            $usuario = $resultado->fetch_object(Usuarios::class);
            
            return $usuario;
        } else {
            return null;
        }
    } 



   




    public function getBySid($sid):Usuarios|null{
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE sid = ?")){
            echo "Error en la SQL:".$this->conn->error;
        }
        $stmt->bind_param('s',$sid);
        $stmt->execute();
        $result=$stmt->get_result();

        if($result->num_rows >=1){
            $usuario=$result->fetch_object(Usuarios::class);
            return $usuario;
        }else{
            return null;
        }
    }


    function insert(Usuarios $usuario): int|bool{
        if(!$stmt = $this->conn->prepare("INSERT INTO usuarios (correo, password ,nombre,apellidos,rol,foto,sid) VALUES (?,?,?,?,?,?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
        $correo = $usuario->getCorreo();
        $password = $usuario->getPassword();
        $nombre=$usuario->getNombre();
        $apellidos=$usuario->getApellidos();
        $foto = $usuario->getFoto();
        $sid = $usuario->getSid();
        $rol=$usuario->getRol();
        $stmt->bind_param('sssssss',$correo, $password,$nombre,$apellidos,$rol,$foto,$sid);
        if($stmt->execute()){
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    }
    

    function generarNombreArchivo(string $nombreOriginal):string {
        $nuevoNombre = md5(time()+rand());
        $partes = explode('.',$nombreOriginal);
        $extension = $partes[count($partes)-1];
        return $nuevoNombre.'.'.$extension;
    }

    public function getAll(): array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM usuarios")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        $stmt->execute();
        $result = $stmt->get_result();
    
        $array_usuarios = array();
        while ($usuario = $result->fetch_object('usuarios')) {
            $array_usuarios[] = $usuario;
        }
        return $array_usuarios;
    }

    function update($usuario){
        if(!$stmt = $this->conn->prepare("UPDATE usuarios SET nombre=?, apellidos=?,rol=? WHERE id=?")){
            die("Error al preparar la consulta update: " . $this->conn->error );
        }
       

        $nombre=$usuario->getNombre();
        $apellidos=$usuario->getApellidos();
        $rol=$usuario->getRol();
       
        $id = $usuario->getId();
        $stmt->bind_param('sssi',$nombre,$apellidos,$rol,$id);
        return $stmt->execute();
    }
   
    
    }




?>