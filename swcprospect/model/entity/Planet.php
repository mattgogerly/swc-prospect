<?php
namespace swcprospect\model\entity;

use JsonSerializable;

/**
 * Planet is the top level construct for SWC Prospect. It has a grid of Tiles, with different
 * terrain types, and a grid of Deposits, with different material types and sizes.
 */
class Planet implements JsonSerializable {
    
    private ?int $id;
    private string $name;
    private EntityType $type;
    private int $size;
    private array $tileMap;
    private array $depositMap;

    /**
     * Create a new Planet instance.
     *
     * @param int        $id   ID of the planet.
     * @param string     $name name of the Planet.
     * @param EntityType $type type ID of the Planet atmosphere.
     * @param int        $size dimension of one axis of the Planet.
     * 
     * @return void
     */
    public function __construct(?int $id, string $name, EntityType $type, int $size) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->size = $size;
    }

    /**
     * Get the value of id.
     * 
     * @return int ID of this Planet.
     */ 
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Set the value of id.
     * 
     * @return void
     */ 
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * Get the value of name.
     * 
     * @return string name of this Planet.
     */ 
    public function getName(): string {
        return $this->name;
    }

    /**
     * Get the value of type.
     * 
     * @return EntityType type of this Planet.
     */ 
    public function getType(): EntityType {
        return $this->type;
    }

    /**
     * Get the value of size.
     * 
     * @return int size of this Planet.
     */ 
    public function getSize(): int {
        return $this->size;
    }

    /**
     * Get the value of tileMap.
     * @see Tile
     * 
     * @return array map of Tiles on this Planet.
     */ 
    public function getTileMap(): array {
        return $this->tileMap;
    }

    /**
     * Set the value of tileMap.
     * @see Tile
     * 
     * @return void
     */ 
    public function setTileMap($tileMap): void {
        $this->tileMap = $tileMap;
    }

    /**
     * Get the value of depositMap.
     * @see Deposit
     * 
     * @return array map of Deposits on this Planet.
     */ 
    public function getDepositMap(): array {
        return $this->depositMap;
    }

    /**
     * Set the value of depositsMap.
     * @see Deposit
     * 
     * @return void
     */ 
    public function setDepositMap($depositMap): void {
        $this->depositMap = $depositMap;
    }

    /**
     * Serialize this Planet as JSON.
     *
     * @return mixed JSON representation of this Planet.
     */
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