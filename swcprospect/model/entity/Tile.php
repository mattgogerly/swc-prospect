<?php

namespace swcprospect\model\entity;

class Tile {
    
    private int $planet;
    private int $x;
    private int $y;
    private EntityType $type;

    public function __construct(int $planet, int $x, int $y, EntityType $type,) {
        $this->planet = $planet;
        $this->x = $x;
        $this->y = $y;
        $this->type = $type;
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

    /**
     * Get the value of type
     */ 
    public function getType(): EntityType {
        return $this->type;
    }
}
?>