<?php

namespace swcprospect\controller;

use swcprospect\model\EntityTypeModel;

/**
 * Controller for interacting with the singleton EntityTypeModel.
 */
class EntityTypeController {

    private EntityTypeModel $entityTypeModel;

    /**
     * Constructs an instance of DepositController.
     * 
     * @param EntityTypeModel $model model for EntityType entities, injected by DI.
     */
    public function __construct(EntityTypeModel $entityTypeModel) {
        $this->entityTypeModel = $entityTypeModel;
    }

    /**
     * Returnss Planet types as JSON, useful for JavaScript.
     * @see EntityType
     * 
     * @return string JSON list of Planet types.
     */
    public function planetTypes(): string {
        return json_encode($this->entityTypeModel->getPlanetTypes());
    }

    /**
     * Returnss Deposit types as JSON, useful for JavaScript.
     * @see EntityType
     * 
     * @return string JSON list of Deposit types.
     */
    public function depositTypes(): string {
        return json_encode($this->entityTypeModel->getDepositTypes());
    }
}

?>