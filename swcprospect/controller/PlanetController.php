<?php

namespace swcprospect\controller;

use swcprospect\model\PlanetModel;
use swcprospect\model\TileModel;
use swcprospect\model\DepositModel;
use swcprospect\model\entity\EntityType;
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

    public function planet(int $id) {
        echo json_encode($this->getPlanet($id));
    }

    public function planetView(int $id): void {
        $planet = $this->getPlanet($id);
        $view = new PlanetView();
        echo $view->render($planet);
    }

    public function save(int $id =  NULL, string $name, int $type, int $size) {
        $planet = new Planet($id, $name, new EntityType($type), $size);
        $this->model->save($planet);
    }

    public function delete(int $id): void {
        $this->tileModel->deleteByPlanet($id);
        $this->depositModel->deleteByPlanet($id);
        $this->model->delete($id);
    }

    private function getPlanet(int $id): Planet {
        $planet = $this->model->getById($id);

        // get tile map for this planet
        $tiles = $this->tileModel->getByPlanet($id);
        $planet->setTileMap($this->createMap($planet->getSize(), $tiles));

        // get deposit map for this planet
        $deposits = $this->depositModel->getByPlanet($id);
        $planet->setDepositMap($this->createMap($planet->getSize(), $deposits));

        return $planet;
    }

    private function createMap(int $planetSize, array $objects) {
        $map = array_fill(0, $planetSize, array_fill(0, $planetSize, NULL));

        foreach ($objects as $o) {
            $map[$o->getY()][$o->getX()] = $o;
        }

        return $map;
    }
}

?>