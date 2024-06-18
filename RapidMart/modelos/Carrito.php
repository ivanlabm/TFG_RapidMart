<?php

class Carrito{
    private $id;
    private $idProducto;
    private $idUsuario;


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


    public function getIdProducto()
    {
        return $this->idProducto;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setIdProducto($idProducto)
    {
        $this->idProducto = $idProducto;

        return $this;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }


}