<?php

namespace swcprospect\model\entity;

class Tile {
    
    private int $id;
    private int $type;
    private int $planet;
    private int $x;
    private int $y;

    public function __construct(int $id, int $type, int $planet, int $x, int $y) {
        $this->id = $id;
        $this->type = $type;
        $this->planet = $planet;
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * Get the value of id
     */ 
    public function getId(): int {
        return $this->id;
    }

    /**
     * Get the value of type
     */ 
    public function getType(): int {
        return $this->type;
    }

    /**
     * Get the value of planet
     */ 
    public function getPlanet(): int {
        return $this->planet;
    }

    /**
     * Get the value of x
     */ 
    public function getX(): int {
        return $this->x;
    }

    /**
     * Get the value of y
     */ 
    public function getY(): int {
        return $this->y;
    }
}
?>