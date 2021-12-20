<?php

namespace swcprospect\model\entity;

class Planet {
    
    private $id;
    private $name;
    private $type;
    private $size;
    private $tileMap;
    private $depositMap;

    public function __construct($id, $name, $type, $size) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->size = $size;
    }

    /**
     * Get the value of id
     */ 
    public function getId() {
        return $this->id;
    }

    /**
     * Get the value of name
     */ 
    public function getName() {
        return $this->name;
    }

    /**
     * Get the value of type
     */ 
    public function getType() {
        return $this->type;
    }

    /**
     * Get the value of size
     */ 
    public function getSize() {
        return $this->size;
    }

    /**
     * Get the value of tileMap
     */ 
    public function getTileMap()
    {
        return $this->tileMap;
    }

    /**
     * Set the value of tileMap
     *
     * @return  self
     */ 
    public function setTileMap($tileMap)
    {
        $this->tileMap = $tileMap;
        return $this;
    }

    /**
     * Get the value of depositMap
     */ 
    public function getDepositMap()
    {
        return $this->depositMap;
    }

    /**
     * Set the value of depositsMap
     *
     * @return  self
     */ 
    public function setDepositMap($depositMap)
    {
        $this->depositMap = $depositMap;
        return $this;
    }
}
?>