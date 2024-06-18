<?php 

class foto{
    private $id;
    private $foto;
    private $idAnuncio;


    public function getAnuncio(){

        if(is_null($this->idAnuncio)){
            $connexionDB= new ConnexionDB('root','','localhost','wallatong');
            $conn=$connexionDB->getConnexion();
            $productosDAO=new ProductosDAO($conn);
            $this->idAnuncio=$productosDAO->getById($this->getAnuncio());
        }
        return $this->idAnuncio;
    }

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
     * Get the value of foto
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set the value of foto
     */
    public function setFoto($foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get the value of idAnuncio
     */
    public function getIdAnuncio()
    {
        return $this->idAnuncio;
    }

    /**
     * Set the value of idAnuncio
     */
    public function setIdAnuncio($idAnuncio): self
    {
        $this->idAnuncio = $idAnuncio;

        return $this;
    }
}
?>