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
     * Get the value of planet.
     * 
     * @return int ID of the Planet this Deposit belongs to.
     */ 
    public function getPlanet(): int {
        return $this->planet;
    }

    /**
     * Get the value of x.
     * 
     * @return int x coordinate of this Deposit.
     */ 
    public function getX(): int {
        return $this->x;
    }

    /**
     * Get the value of y.
     * 
     * @return int y coordinate of this Deposit.
     */ 
    public function getY(): int {
        return $this->y;
    }

    /**
     * Get the value of type.
     * 
     * @return EntityType type of this Deposit.
     */ 
    public function getType(): EntityType {
        return $this->type;
    }
  
    /**
     * Get the value of size.
     *
     * @return int size of this Deposit.
     */
    public function getSize(): int {
        return $this->size;
    }
    
    /**
     * Serialize this Deposit as JSON.
     *
     * @return mixed JSON representation of this Deposit.
     */
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