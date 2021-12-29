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

/**
 * Controller for interacting with the singleton PlanetModel.
 */
class PlanetController {

    private PlanetModel $model;
    private TileModel $tileModel;
    private DepositModel $depositModel;

    /**
     * Constructs an instance of PlanetController.
     * 
     * @param PlanetModel  $model        model for Planet entities, injected by DI.   
     * @param TileModel    $tileModel    model for Tile entities, injected by DI.
     * @param DepositModel $depositModel model for Deposit entities, injected by DI.
     */
    public function __construct(PlanetModel $model, TileModel $tileModel, DepositModel $depositModel) {
        $this->model = $model;
        $this->tileModel = $tileModel;
        $this->depositModel = $depositModel;
    }

    /**
     * Renders a list of Planets in table format.
     * @see Planet
     * @see PlanetListView
     * 
     * @return string list of Planets in HTML table format.
     */
    public function planetListView(): string {
        $planets = $this->model->getAll();
        $view = new PlanetListView();
        return $view->render($planets);
    }

    /**
     * Returns a Planet as JSON, useful for JavaScript.
     * @see Planet
     * 
     * @param int $planetId the id of the Planet to return.
     * 
     * @return string JSON representation of the Planet.
     */
    public function planetJson(int $planetId): string {
        return json_encode($this->getPlanet($planetId));
    }

    /**
     * Renders a Planet in table format.
     * @see Planet
     * @see PlanetView
     * 
     * @param int $planetId the id of the Planet to return.
     * 
     * @return string Planet data in HTML table format.
     */
    public function planet(int $planetId): string {
        $planet = $this->getPlanet($planetId);
        $view = new PlanetView();
        return $view->render($planet);
    }

    /**
     * Persists a Planet entity in the model.
     * 
     * Upserts a Planet, then upserts the Tiles representing the Planet. Terrain map size must
     * match the size of the Planet.
     * 
     * @see Planet
     * @see EntityType
     * @see Tile
     * 
     * @param ?int   $planetId   the id of the Planet, null if new.
     * @param string $name       the name of the Planet.
     * @param int    $type       the EntityType ID for the Planet type.
     * @param int    $size       the dimension of the planet on one axis.
     * @param string $terrainMap a comma separated string of EntityType IDs for Tiles.
     * 
     * @return string JSON representation of the Planet.
     */
    public function save(?int $planetId, string $name, int $type, int $size, string $terrainMap): string {
        $this->validatePlanetData($planetId, $name, $size);
        $validatedTerrainMap = $this->validateTerrainMap($terrainMap, $size);

        $planet = new Planet($planetId, $name, new EntityType($type), $size);
        $planetId = $this->model->save($planet);
        $planet->setId($planetId);

        $x = $y = 0;
        foreach ($validatedTerrainMap as $tile) {
            $tile = new Tile($planetId, $x, $y, new EntityType(intval($tile)));
            $this->tileModel->save($tile);

            if ($x == $size - 1) {
                // new row so reset x and increment y
                $x = 0;
                $y++;
            } else {
                $x++;
            }
        }

        return json_encode($planet);
    }

    /**
     * Deletes a Planet entity from the model.
     * @see Planet
     * 
     * @param int $planetId the ID of the Planet to delete.
     */
    public function delete(int $planetId): void {
        $this->model->delete($planetId);
    }

        
    /**
     * Validates that the data provided when creating a planet is valid. Triggers a 400
     * response if a field is not valid.
     *
     * @param ?int   $planetId the id of the Planet, null if new.
     * @param string $name     the name coord of the Planet.
     * @param int    $size     the dimension of the planet on one axis.
     * 
     * @return void
     */
    private function validatePlanetData(?int $planetId, string $name, int $size): void {
        if ($planetId && $planetId < 1) {
            trigger_error('400: Planet ID must be a positive integer');
        }
        
        if (strlen($name) < 1) {
            trigger_error('400: Planet name must be provided');
        }
        
        if ($size < 1) {
            trigger_error('400: Planet size must be a positive integer');
        }
    }

    /**
     * Validates that the terrain map provided when upserting a planet is valid. Triggers a 400
     * response if not.
     *
     * @param string $terrainMap a comma separated string of EntityType IDs for Tiles.
     * @param int    $size       the dimension of the planet on one axis.
     * 
     * @return array
     */
    private function validateTerrainMap(string $terrainMap, int $planetSize): array {
        $splitTiles = explode(',', $terrainMap);
        if (count($splitTiles) != $planetSize * $planetSize) {
            trigger_error('400: Size of planet tile map does not match size of planet');
        }

        if (!array_reduce($splitTiles, function ($result, $item) { return $result && intval($item) > 0; }, true)) {
            trigger_error('400: Values in terrain map must be positive integers');
        }

        return $splitTiles;
    }

    /**
     * Utility method to get a Planet from the model. Populates the tileMap and depositMap fields
     * as arrays representing the layout of the respective entities on the Planet grid.
     * 
     * @see Planet
     * @see Tile
     * @see Deposit
     * 
     * @param int $planetId the ID of the Planet to retrieve.
     * 
     * @return Planet Planet with ID retrieved from PlanetModel.
     */
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

    /**
     * Utility method to create a map (3D array) representing a Planet grid,
     * with entity IDs populated at their coordinates.
     * 
     * @see Planet
     * @see Tile
     * @see Deposit
     * 
     * @param int $planetSize the dimension of one axis of the Planet, 
     *                        used to fill the map with NULLs.
     * @param array $entities the entities to place in the map.
     * 
     * @return Planet Planet with ID retrieved from PlanetModel.
     */
    private function createMap(int $planetSize, array $entities): array {
        $map = array_fill(0, $planetSize, array_fill(0, $planetSize, NULL));

        foreach ($entities as $e) {
            $map[$e->getY()][$e->getX()] = $e;
        }

        return $map;
    }
}

?>