<?php 

class Tarea {
    private $id;
    private $texto;
    private $fecha;
    private $idUsuario;
    private $usuario;
    private $realizado;



    public function getUsuario(){
        if(is_null($this->usuario)){
            $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
            $conn = $connexionDB->getConnexion();
            $usuariosDAO = new UsuariosDAO($conn);
            $this->usuario = $usuariosDAO->getById($this->getIdUsuario());
        }
        return $this->usuario;
    }



   
    public function toJSON(){
        return json_encode(
                ['id'=>$this->getId(),
                'texto' => $this->getTexto(),
                'fecha' => $this->getFecha()]
        );
    }

    /**
     * Get the value of id
     */
 
     

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of texto
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set the value of texto
     */
    public function setTexto($texto): self
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get the value of fecha
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     */
    public function setFecha($fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of idUsuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set the value of idUsuario
     */
    public function setIdUsuario($idUsuario): self
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get the value of usuario
     */

    /**
     * Set the value of usuario
     */
    public function setUsuario($usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get the value of realizado
     */
    public function getRealizado()
    {
        return $this->realizado;
    }

    /**
     * Set the value of realizado
     */
    public function setRealizado($realizado): self
    {
        $this->realizado = $realizado;

        return $this;
    }
}
