<?php

namespace swcprospect\model\entity;

use JsonSerializable;

class Deposit implements JsonSerializable {
    
    private int $planet;
    private int $x;
    private int $y;
    private EntityType $type;
    private int $size;

    public function __construct(int $planet, int $x, int $y, EntityType $type, int $size) {
        $this->planet = $planet;
        $this->x = $x;
        $this->y = $y;
        $this->type = $type;
        $this->size = $size;
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

    /**
     * Get the value of size
     */ 
    public function getSize(): int {
        return $this->size;
    }

    public function jsonSerialize(): mixed {
        return [
            'planet' => $this->planet,
            'x' => $this->x,
            'y' => $this->y,
            'type' => $this->type,
            'size' => $this->size,
        ];
    }
}
?>