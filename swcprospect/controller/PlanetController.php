<?php

namespace swcprospect\controller;

use swcprospect\model\PlanetModel;
use swcprospect\model\TileModel;
use swcprospect\model\DepositModel;
use swcprospect\view\PlanetListView;
use swcprospect\view\PlanetView;

class PlanetController {

    private $model;
    private $tileModel;
    private $depositModel;

    public function __construct(PlanetModel $model, TileModel $tileModel, DepositModel $depositModel) {
        $this->model = $model;
        $this->tileModel = $tileModel;
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

        // get tiles for this planet
        $tileMap = $this->tileModel->getByPlanet($id, $planet->getSize());
        $planet->setTileMap($tileMap);

        // get deposits for this planet
        $depositMap = $this->depositModel->getByPlanet($id, $planet->getSize());
        $planet->setDepositMap($depositMap);

        $view = new PlanetView();
        echo $view->render($planet);
    }
}

?>