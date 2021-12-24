<?php

namespace swcprospect\model\entity;

use JsonSerializable;

class PlanetType implements JsonSerializable {

    private int $id;
    private string $name;

    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Get the value of id
     */ 
    public function getId(): int {
        return $this->id;
    }

    /**
     * Get the value of name
     */ 
    public function getName(): string {
        return $this->name;
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
?>