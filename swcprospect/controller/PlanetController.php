<?php

namespace swcprospect\controller;

use swcprospect\model\PlanetModel;
use swcprospect\model\DepositModel;
use swcprospect\view\PlanetListView;
use swcprospect\view\PlanetView;

class PlanetController {

    private $model;
    private $depositModel;

    public function __construct(PlanetModel $model, DepositModel $depositModel) {
        $this->model = $model;
        $this->depositModel = $depositModel;
    }

    public function planets() {
        $planets = $this->model->getAll();
        $view = new PlanetListView();
        echo $view->render($planets);
    }

    public function planet(int $id) {
        if (filter_var($id, FILTER_VALIDATE_INT) === false) {
            echo 'Invalid planet ID provided';
            return;
        }

        $planet = $this->model->getById($id);
        $depositMap = $this->depositModel->getByPlanet($id, $planet->getSize());
        $planet->setDepositMap($depositMap);

        $view = new PlanetView();
        echo $view->render($planet);
    }
}

?>