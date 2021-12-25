<?php

namespace swcprospect\model\entity;

use JsonSerializable;

class Planet implements JsonSerializable {
    
    private ?int $id;
    private string $name;
    private EntityType $type;
    private int $size;
    private array $tileMap;
    private array $depositMap;

    public function __construct(?int $id, string $name, EntityType $type, int $size) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->size = $size;
    }

    /**
     * Get the value of id
     */ 
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Set the value of id
     */ 
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * Get the value of name
     */ 
    public function getName(): string {
        return $this->name;
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

    /**
     * Get the value of tileMap
     */ 
    public function getTileMap(): array {
        return $this->tileMap;
    }

    /**
     * Set the value of tileMap
     */ 
    public function setTileMap($tileMap): void {
        $this->tileMap = $tileMap;
    }

    /**
     * Get the value of depositMap
     */ 
    public function getDepositMap(): array {
        return $this->depositMap;
    }

    /**
     * Set the value of depositsMap
     */ 
    public function setDepositMap($depositMap): void {
        $this->depositMap = $depositMap;
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'size' => $this->size
        ];
    }
}
?>