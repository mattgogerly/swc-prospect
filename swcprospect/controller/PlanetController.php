<?php

namespace swcprospect\controller;

use swcprospect\model\PlanetModel;
use swcprospect\model\TileModel;
use swcprospect\model\DepositModel;
use swcprospect\model\entity\EntityType;
use swcprospect\model\entity\Planet;
use swcprospect\model\entity\Tile;
use swcprospect\view\PlanetListView;
use swcprospect\view\PlanetView;

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

    public function planet(int $id): void {
        echo json_encode($this->getPlanet($id));
    }

    public function planetView(int $id): void {
        $planet = $this->getPlanet($id);
        $view = new PlanetView();
        echo $view->render($planet);
    }

    public function save(int $id =  NULL, string $name, int $type, int $size, string $tiles): void {
        $planet = new Planet($id, $name, new EntityType($type), $size);
        $planetId = $this->model->save($planet);

        $splitTiles = explode(',', $tiles);
        if (count($splitTiles) != $size * $size) {
            trigger_error("400: Size of planet tile map doesn't match size of planet" . count($splitTiles));
        }

        $x = 0;
        $y = 0;
        foreach ($splitTiles as $typeId) {
            $tile = new Tile($planetId, $x, $y, new EntityType(intval($typeId)));
            $this->tileModel->save($tile);

            if ($x == $size - 1) {
                // new row so reset x and increment y
                $x = 0;
                $y++;
            } else {
                $x++;
            }
        }
    }

    public function delete(int $id): void {
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

    private function createMap(int $planetSize, array $objects): array {
        $map = array_fill(0, $planetSize, array_fill(0, $planetSize, NULL));

        foreach ($objects as $o) {
            $map[$o->getY()][$o->getX()] = $o;
        }

        return $map;
    }
}

?>