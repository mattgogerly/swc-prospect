<?php

namespace swcprospect\model;

use swcprospect\model\db\DatabaseConnection;

abstract class Model
{
    protected $db;

    public function __construct(DatabaseConnection $db)
    {
        $this->db = $db;
    }
}
