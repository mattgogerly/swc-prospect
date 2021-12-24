<?php

namespace swcprospect\model;

use swcprospect\model\Model;
use swcprospect\model\db\Query;
use swcprospect\model\entity\EntityType;
use swcprospect\model\entity\Tile;

class TileModel extends Model {

    public function getById(int $id): Tile {
        try {
            $stmt = $this->db->getConn()->prepare(Query::GET_TILE);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $this->convertToEntity($res);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function getTileMapForPlanet(int $planetId, int $planetSize): array {
        try {
            $stmt = $this->db->getConn()->prepare(Query::GET_TILES_BY_PLANET);
            $stmt->bindParam(':planetId', $planetId, \PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // init map to NULL
            $tileMap = array_fill(0, $planetSize, array_fill(0, $planetSize, NULL));

            // set IDs for deposists in map
            foreach ($res as $d) {
                $tileMap[$d['y']][$d['x']] = $this->convertToEntity($d);
            }

            return $tileMap;
        } catch (\PDOException $e) {
            echo $e;
            return null;
        }
    }

    public function save(Tile $tile) {
        try {
            //
        } catch (\PDOException $e) {
            echo "";
        }
    }

    public function deleteByPlanet(int $planetId): void {
        try {
            $stmt = $this->db->getConn()->prepare(Query::DELETE_TILES_BY_PLANET);
            $stmt->bindParam(':planetId', $planetId, \PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            echo "";
        }
    }

    private function convertToEntity($arr): Tile {
        $type = new EntityType($arr['type_id'], $arr['type_name']);
        return new Tile($arr['id'], $type, $arr['planet'], $arr['x'], $arr['y']);
    }
}
?>