<?php

namespace swcprospect\model\entity;

class Tile {
    
    private $id;
    private $type;
    private $planet;
    private $x;
    private $y;

    public function __construct($id, $type, $planet, $x, $y) {
        $this->id = $id;
        $this->type = $type;
        $this->planet = $planet;
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * Get the value of id
     */ 
    public function getId() {
        return $this->id;
    }

    /**
     * Get the value of type
     */ 
    public function getType() {
        return $this->type;
    }

    /**
     * Get the value of planet
     */ 
    public function getPlanet() {
        return $this->planet;
    }

    /**
     * Get the value of x
     */ 
    public function getX() {
        return $this->x;
    }

    /**
     * Get the value of y
     */ 
    public function getY() {
        return $this->y;
    }
}
?>