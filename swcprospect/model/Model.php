<?php

namespace swcprospect\model;

use swcprospect\model\db\DatabaseConnection;

/**
 * Model is a parent class for entity models, holding the DB connection.
 */
abstract class Model
{
    protected $db;

    /**
    * Create a new instance of Model. Populates the value of {@var $db}.
    *
    * @return void
    */
    public function __construct(DatabaseConnection $db)
    {
        $this->db = $db;
    }
}
