<?php

namespace swcprospect\model\entity;

class Deposit {
    
    private $id;
    private $planet;
    private $x;
    private $y;
    private $type;
    private $size;

    public function __construct($planet, $x, $y, $type, $size) {
        $this->planet = $planet;
        $this->x = $x;
        $this->y = $y;
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
}
?>