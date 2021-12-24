<?php

namespace swcprospect\model;

use swcprospect\model\Model;
use swcprospect\model\db\Query;
use swcprospect\model\entity\Planet;
use swcprospect\model\entity\EntityType;
use PDO;
use PDOException;

class PlanetModel extends Model {

    public function getAll(): array {
        try {
            $res = $this->db->getConn()->query(Query::GET_PLANETS);
            
            $planets = [];
            foreach ($res as $p) {
                array_push($planets, $this->convertToEntity($p));
            }

            return $planets;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return [];
        }
   }

   public function getById($id): Planet {
        try {
            $stmt = $this->db->getConn()->prepare(Query::GET_PLANET);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            $stmt->execute();
            $res = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            return $this->convertToEntity($res);
        } catch (\PDOException $e) {
            return null;
        }
   }

    public function save(Planet $planet) {
        try {
            $query = $planet->getId() ? Query::UPDATE_PLANET : Query::SAVE_PLANET;
            $stmt = $this->db->getConn()->prepare($query);

            if ($planet->getId()) {
                $stmt->bindValue(':id', $planet->getId(), PDO::PARAM_INT);
            }

            $stmt->bindValue(':name', $planet->getName());
            $stmt->bindValue(':type', $planet->getType()->getId(), PDO::PARAM_INT);
            $stmt->bindValue(':size', $planet->getSize(), PDO::PARAM_INT);

            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function delete(int $id): void {
        try {
            $stmt = $this->db->getConn()->prepare(Query::DELETE_PLANET);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "";
        }
    }

    private function convertToEntity(array $arr): Planet {
        $type = new EntityType($arr['type_id'], $arr['type_name']);
        return new Planet($arr['id'], $arr['name'], $type, $arr['size']);
    }
}
?>