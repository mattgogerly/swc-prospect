<?php

namespace swcprospect\model\entity;

use JsonSerializable;

class EntityType implements JsonSerializable {

    private int $id;
    private ?string $name;

    public function __construct(int $id, string $name = NULL) {
        $this->id = $id;
        $this->name = $name;
    }
  
    /**
     * Get the value of id.
     *
     * @return int ID of this EntityType.
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Get the value of name.
     * 
     * @return string name of this EntityType.
     */ 
    public function getName(): string {
        return $this->name;
    }

    /**
     * Serialize this EntityType as JSON.
     *
     * @return mixed JSON representation of this EntityType.
     */
    public function jsonSerialize(): mixed {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
?>