<?php

namespace swcprospect\model;

use swcprospect\model\Model;
use swcprospect\model\db\Query;
use swcprospect\model\entity\Planet;
use swcprospect\model\entity\EntityType;

class PlanetModel extends Model {

    public function getAll(): array {
        try {
            $res = $this->db->getConn()->query(Query::GET_PLANETS);
            
            $planets = [];
            foreach ($res as $p) {
                array_push($planets, $this->convertToEntity($p));
            }

            return $planets;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return [];
        }
   }

   public function getById($id): Planet {
        try {
            $stmt = $this->db->getConn()->prepare(Query::GET_PLANET);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $this->convertToEntity($res);
        } catch (\PDOException $e) {
            return null;
        }
   }

    public function save(Planet $planet) {
        try {
            //
        } catch (\PDOException $e) {
            echo "";
        }
    }

    public function delete(int $id): void {
        try {
            $stmt = $this->db->getConn()->prepare(Query::DELETE_PLANET);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            echo "";
        }
    }

    private function convertToEntity(array $arr): Planet {
        $type = new EntityType($arr['type_id'], $arr['type_name']);
        return new Planet($arr['id'], $type, $arr['name'], $arr['size']);
    }
}
?>