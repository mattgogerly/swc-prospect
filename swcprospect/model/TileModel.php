<?php

namespace swcprospect\model;

use PDO;
use PDOException;
use swcprospect\model\db\Query;
use swcprospect\model\entity\EntityType;
use swcprospect\model\entity\Tile;
use swcprospect\model\Model;

/**
 * TileModel is a wrapper for manipulating Tiles in the DB.
 */
class TileModel extends Model
{
    /**
     * Retrieves a Tile from the DB by Planet and X, Y coord.
     * @see Tile
     *
     * @param int $planetId the planet the Deposit is on.
     * @param int $x        the x coord of the Deposit.
     * @param int $y        the y coord of the Deposit.
     *
     * @return Tile Tile object.
     * @throws 404 if not found.
     */
    public function getByPlanetCoord(int $planetId, int $x, int $y): Tile
    {
        try {
            $stmt = $this->db->getConn()->prepare(Query::TILE_BY_COORD);
            $stmt->bindValue(':planetId', $planetId, PDO::PARAM_INT);
            $stmt->bindValue(':x', $x, PDO::PARAM_INT);
            $stmt->bindValue(':y', $y, PDO::PARAM_INT);
            $stmt->execute();

            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $this->convertToEntity($res);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            trigger_error('500: Error retrieving tile, try again later');
        }
    }

    /**
     * Retrieves a list of Tiles by Planet.
     * @see Tile
     *
     * @param int $planetId the planet to retrieve Tiles for.
     *
     * @return array array of Tiles on a given Planet.
     */
    public function getByPlanet(int $planetId): array
    {
        try {
            $stmt = $this->db->getConn()->prepare(Query::TILES_BY_PLANET);
            $stmt->bindValue(':planetId', $planetId, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $tileList = array();
            foreach ($res as $t) {
                array_push($tileList, $this->convertToEntity($t));
            }

            return $tileList;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            trigger_error('500: Error retrieving tiles, try again later');
        }
    }

    /**
     * Saves a Tile to the DB.
     * @see Tile
     *
     * @param Tile $tile Tile object to be saved.
     *
     * @return void
     */
    public function save(Tile $tile): void
    {
        try {
            $stmt = $this->db->getConn()->prepare(Query::SAVE_TILE);

            $stmt->bindValue(':planetId', $tile->getPlanetId(), PDO::PARAM_INT);
            $stmt->bindValue(':x', $tile->getX(), PDO::PARAM_INT);
            $stmt->bindValue(':y', $tile->getY(), PDO::PARAM_INT);
            $stmt->bindValue(':type', $tile->getType()->getId(), PDO::PARAM_INT);

            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            trigger_error('500: Error saving tile, try again later');
        }
    }

    /**
     * Utility to convert a row from the DB to a Tile object.
     * @see Tile
     *
     * @param array $arr Array of data from the DB containing fields for a Tile.
     *
     * @return Tile Tile object from the data in the DB.
     */
    private function convertToEntity($arr): Tile
    {
        $type = new EntityType($arr['type_id'], $arr['type_name']);
        return new Tile($arr['planet'], $arr['x'], $arr['y'], $type);
    }
}
