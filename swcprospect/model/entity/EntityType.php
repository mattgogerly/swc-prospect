<?php

namespace swcprospect\model\entity;

use JsonSerializable;

/**
 * EntityType is a wrapper class for the various `type` fields of other entities, 
 * e.g. Planet atmosphere.
 */
class EntityType implements JsonSerializable {

    private int $id;
    private ?string $name;

    /**
     * Create a new EntityType instance, e.g. Planet atmosphere or Deposit material.
     *
     * @param int    $id   ID of the type.
     * @param string $name name of the type.
     * 
     * @return void
     */
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