<?php

namespace swcprospect\model\entity;

class Planet {
    
    private int $id;
    private EntityType $type;
    private string $name;
    private int $size;
    private array $tileMap;
    private array $depositMap;

    public function __construct(int $id, EntityType $type, string $name, int $size) {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
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
     * Get the value of name
     */ 
    public function getName(): string {
        return $this->name;
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
}
?>