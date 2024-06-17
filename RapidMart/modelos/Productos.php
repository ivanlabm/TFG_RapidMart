<?php

class Productos{
    private $id;
    private $nombre;
    private $descripcion;
    private $foto;
    private $precio;
    private $idVendedor;
    private $categoria;
    private $especificaciones;
    private $stock;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

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
     *
     * @return  self
     */ 
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get the value of precio
     */ 
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     *
     * @return  self
     */ 
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    public function getIdVendedor()
    {
        return $this->idVendedor;
    }

    /**
     * Set the value of precio
     *
     * @return  self
     */ 
    public function setIdVendedor($idVendedor)
    {
        $this->idVendedor = $idVendedor;

        return $this;
    }

    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set the value of foto
     *
     * @return  self
     */ 
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    public function getFotoanu(){

        if(is_null($this->foto)){
            $connexionDB= new ConnexionDB('alumno','','localhost','market');
            $conn=$connexionDB->getConnexion();
            $FotosDAO=new FotosDAO($conn);
            $this->foto=$FotosDAO->getById($this->getFotoanu());
        }
        return $this->foto;
    }

    

    /**
     * Get the value of categoria
     */ 
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set the value of categoria
     *
     * @return  self
     */ 
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get the value of especificaciones
     */ 
    public function getEspecificaciones()
    {
        return $this->especificaciones;
    }

    /**
     * Set the value of especificaciones
     *
     * @return  self
     */ 
    public function setEspecificaciones($especificaciones)
    {
        $this->especificaciones = $especificaciones;

        return $this;
    }
}