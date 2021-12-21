<?php

namespace swcprospect\controller;

use swcprospect\model\PlanetTypeModel;
use swcprospect\model\DepositTypeModel;

class TypeController {

    private $planetTypeModel;
    private $depositTypeModel;

    public function __construct(PlanetTypeModel $planetTypeModel, DepositTypeModel $depositTypeModel) {
        $this->planetTypeModel = $planetTypeModel;
        $this->depositTypeModel = $depositTypeModel;
    }

    public function planetTypes() {
        echo json_encode($this->planetTypeModel->getAll());
    }

    public function depositTypes() {
        echo json_encode($this->depositTypeModel->getAll());
    }
}

?>