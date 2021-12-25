<?php

namespace swcprospect\model;

use swcprospect\model\Model;
use swcprospect\model\db\Query;
use swcprospect\model\entity\Tile;
use swcprospect\model\entity\EntityType;
use PDO;
use PDOException;

class TileModel extends Model {

    public function getByPlanetCoord(int $planetId, int $x, int $y): Tile {
        try {
            $stmt = $this->db->getConn()->prepare(Query::TILE_BY_COORD);
            $stmt->bindValue(':planetId', $planetId, PDO::PARAM_INT);
            $stmt->bindValue(':x', $x, PDO::PARAM_INT);
            $stmt->bindValue(':y', $y, PDO::PARAM_INT);
            $stmt->execute();

            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $this->convertToEntity($res);
        } catch (PDOException $e) {
            trigger_error('500: Error retrieving tile, try again later');
        }
    }

    public function getByPlanet(int $planetId): array {
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
            trigger_error('500: Error retrieving tiles, try again later');
        }
    }

    public function save(Tile $tile): void {
        try {
            //
        } catch (PDOException $e) {
            trigger_error('500: Error saving tile, try again later');
        }
    }

    public function deleteByPlanet(int $planetId): void {
        try {
            $stmt = $this->db->getConn()->prepare(Query::DELETE_TILES);
            $stmt->bindValue(':planetId', $planetId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error('500: Error deleting tiles, try again later');
        }
    }

    private function convertToEntity($arr): Tile {
        $type = new EntityType($arr['type_id'], $arr['type_name']);
        return new Tile($arr['planet'], $arr['x'], $arr['y'], $type);
    }
}
?>