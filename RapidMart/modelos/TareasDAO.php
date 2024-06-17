<?php

class TareasDAO {
    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli("localhost", "alumno", "", "tareas");

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function getAll() {
        $query = "SELECT * FROM tareas";
        $resultados = $this->conexion->query($query);
        $tareas = array();

        if ($resultados->num_rows > 0) {
            while ($tarea = $resultados->fetch_object(Tarea::class)) {
                $tareas[] = $tarea;
            }
        }

        return $tareas;
    }


  

    // public function insert($texto) {
    //     $texto = $this->conexion->real_escape_string($texto);
    //     $idUsuario=Sesion::getUsuario()->getId();
    //     $realizado=0;
    //     $query = "INSERT INTO tareas (texto,idUsuario,realizado) VALUES ('$texto','$idUsuario','$realizado')";
        
    //     if ($this->conexion->query($query) === TRUE) {
    //         $idInsertado = $this->conexion->insert_id;
    //         $nuevaTarea = $this->getById($idInsertado);
    //         return $nuevaTarea;
    //     } else {
    //         return null;
    //     }
    // }

    public function insert(Tarea $tarea): int|bool{
        if(!$stmt = $this->conexion->prepare("INSERT INTO tareas (texto, realizado, idUsuario) VALUES (?,?,?)")){
            die("Error al preparar la consulta insert: " . $this->conexion->error );
        }
        $texto = $tarea->getTexto();
        $realizada = $tarea->getRealizado();
        $idUsuario = $tarea->getIdUsuario();
        $stmt->bind_param('sii', $texto, $realizada, $idUsuario);
        if($stmt->execute()){
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    }



    public function getById($id) :Tarea|null{
        $query = "SELECT * FROM tareas WHERE id = $id";
        $resultado = $this->conexion->query($query);

        if ($resultado->num_rows > 0) {
            $tarea = $resultado->fetch_object(Tarea::class);
            
            return $tarea;
        } else {
            return null;
        }
    }
    public function getByIdUsuario($idUsuario) : array{
        $idUsuario = filter_var($idUsuario,FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT * FROM tareas where idUsuario=$idUsuario";
        $resultados = $this->conexion->query($query);
        $tareas = array();

        if ($resultados->num_rows > 0) {
            while ($tarea = $resultados->fetch_object(Tarea::class)) {
                $tareas[] = $tarea;
            }
        }

        return $tareas;
        }
    

    public function cerrarConexion() {
        $this->conexion->close();
    }


   // public function delete($id) {
     //   $id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
       // $query = "delete from tareas where id=$id";
        
       // $this->conexion->query($query);
        //if($this->conexion->affected_rows==1){
          //  return true;
        //} else {
          //  return false;
       // }
    //}

    function delete($id):bool{

        if(!$stmt = $this->conexion->prepare("DELETE FROM tareas WHERE id = ?"))
        {
            echo "Error en la SQL: " . $this->conexion->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$id);
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

    function update($tarea){
        if(!$stmt = $this->conexion->prepare("UPDATE tareas SET texto=?, idUsuario=? ,realizado=? WHERE id=?")){
            die("Error al preparar la consulta update: " . $this->conexion->error );
        }
        $texto = $tarea->getTexto();
        $idUsuario = $tarea->getIdUsuario();
        $realizado=$tarea->getRealizado();
        $id = $tarea->getId();
        $stmt->bind_param('siii', $texto, $idUsuario,$realizado,$id);
        return $stmt->execute();
    }
}






  

?>
