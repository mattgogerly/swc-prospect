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

    public function planetListView(): void {
        $planets = $this->model->getAll();
        $view = new PlanetListView();
        echo $view->render($planets);
    }

    public function planetJson(int $planetId): void {
        echo json_encode($this->getPlanet($planetId));
    }

    public function planet(int $planetId): void {
        $planet = $this->getPlanet($planetId);
        $view = new PlanetView();
        echo $view->render($planet);
    }

    public function save(?int $planetId, string $name, int $type, int $size, string $terrainMap): void {
        $planet = new Planet($planetId, $name, new EntityType($type), $size);
        $planetId = $this->model->save($planet);
        $planet->setId($planetId);

        $splitTiles = explode(',', $terrainMap);
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

        echo json_encode($planet);
    }

    public function delete(int $planetId): void {
        $this->model->delete($planetId);
    }

    private function getPlanet(int $planetId): Planet {
        $planet = $this->model->getById($planetId);

        // get tile map for this planet
        $tiles = $this->tileModel->getByPlanet($planetId);
        $planet->setTileMap($this->createMap($planet->getSize(), $tiles));

        // get deposit map for this planet
        $deposits = $this->depositModel->getByPlanet($planetId);
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