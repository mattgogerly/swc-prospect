<?php

namespace swcprospect\model\entity;

class Deposit {
    
    private int $id;
    private EntityType $type;
    private int $planet;
    private int $x;
    private int $y;
    private int $size;

    public function __construct(int $id, EntityType $type, int $planet, int $x, int $y, int $size) {
        $this->id = $id;
        $this->type = $type;
        $this->planet = $planet;
        $this->x = $x;
        $this->y = $y;
        $this->size = $size;
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
    public function getType(): EntityType {
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

    /**
     * Get the value of size
     */ 
    public function getSize(): int {
        return $this->size;
    }
}
?>