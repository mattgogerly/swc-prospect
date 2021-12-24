<?php

namespace swcprospect\controller;

use swcprospect\model\EntityTypeModel;

class EntityTypeController {

    private EntityTypeModel $entityTypeModel;

    public function __construct(EntityTypeModel $entityTypeModel) {
        $this->entityTypeModel = $entityTypeModel;
    }

    public function planetTypes() {
        echo json_encode($this->entityTypeModel->getPlanetTypes());
    }

    public function depositTypes() {
        echo json_encode($this->depositTypeModel->getDepositTypes());
    }
}

?>