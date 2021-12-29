<?php

namespace swcprospect\model;

use PDO;
use PDOException;
use swcprospect\model\db\Query;
use swcprospect\model\entity\EntityType;
use swcprospect\model\entity\Tile;
use swcprospect\model\Model;

class TileModel extends Model
{
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

    public function deleteByPlanet(int $planetId): void
    {
        try {
            $stmt = $this->db->getConn()->prepare(Query::DELETE_TILES);
            $stmt->bindValue(':planetId', $planetId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            trigger_error('500: Error deleting tiles, try again later');
        }
    }

    private function convertToEntity($arr): Tile
    {
        $type = new EntityType($arr['type_id'], $arr['type_name']);
        return new Tile($arr['planet'], $arr['x'], $arr['y'], $type);
    }
}
