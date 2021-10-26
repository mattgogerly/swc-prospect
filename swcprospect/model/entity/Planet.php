<?php

namespace swcprospect\model\entity;

use swcprospect\model\Model;

class Planet extends Model {
    
    private $id;
    private $name;
    private $type;
    private $size;

    public function __construct($name, $type, $size, $db) {
        $this->name = $name;
        $this->type = $type;
        $this->size = $size;
    }

    /**
     * Get the value of id
     */ 
    public function getId() {
        return $this->id;
    }

    /**
     * Get the value of name
     */ 
    public function getName() {
        return $this->name;
    }

    /**
     * Get the value of type
     */ 
    public function getType() {
        return $this->type;
    }

    /**
     * Get the value of size
     */ 
    public function getSize() {
        return $this->size;
    }
}
?>