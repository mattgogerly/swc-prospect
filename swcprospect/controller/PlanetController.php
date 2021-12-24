<?php

namespace swcprospect\controller;

use swcprospect\model\PlanetModel;
use swcprospect\model\TileModel;
use swcprospect\model\DepositModel;
use swcprospect\view\PlanetListView;
use swcprospect\view\PlanetView;
use swcprospect\model\entity\Planet;

class PlanetController {

    private PlanetModel $model;
    private TileModel $tileModel;
    private DepositModel $depositModel;

    public function __construct(PlanetModel $model, TileModel $tileModel, DepositModel $depositModel) {
        $this->model = $model;
        $this->tileModel = $tileModel;
        $this->depositModel = $depositModel;
    }

    public function planetsListView(): void {
        $planets = $this->model->getAll();
        $view = new PlanetListView();
        echo $view->render($planets);
    }

    public function planetView(int $id): void {
        if (filter_var($id, FILTER_VALIDATE_INT) === false) {
            echo 'Invalid planet ID provided';
            return;
        }

        $planet = $this->getPlanet($id);
        $view = new PlanetView();
        echo $view->render($planet);
    }

    public function planet(int $id) {
        if (filter_var($id, FILTER_VALIDATE_INT) === false) {
            echo 'Invalid planet ID provided';
            return;
        }

        echo json_encode($this->getPlanet($id));
    }

    public function delete(int $id): void {
        if (filter_var($id, FILTER_VALIDATE_INT) === false) {
            echo 'Invalid planet ID provided';
            return;
        }

        $this->tileModel->deleteByPlanet($id);
        $this->depositModel->deleteByPlanet($id);
        $this->model->delete($id);
    }

    private function getPlanet(int $id): Planet {
        $planet = $this->model->getById($id);

        // get tiles for this planet
        $tileMap = $this->tileModel->getTileMapForPlanet($id, $planet->getSize());
        $planet->setTileMap($tileMap);

        // get deposits for this planet
        $depositMap = $this->depositModel->getDepositMapForPlanet($id, $planet->getSize());
        $planet->setDepositMap($depositMap);

        return $planet;
    }
}

?>