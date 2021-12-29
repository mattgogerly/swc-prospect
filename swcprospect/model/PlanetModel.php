<?php

namespace swcprospect\model;

use swcprospect\model\Model;
use swcprospect\model\db\Query;
use swcprospect\model\entity\Planet;
use swcprospect\model\entity\EntityType;
use PDO;
use PDOException;

class PlanetModel extends Model
{
    public function getAll(): array
    {
        try {
            $res = $this->db->getConn()->query(Query::PLANETS);

            $planets = [];
            foreach ($res as $p) {
                array_push($planets, $this->convertToEntity($p));
            }

            return $planets;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            trigger_error('500: Error retrieving planets, try again later');
        }
    }

    public function getById($id): ?Planet
    {
        try {
            $stmt = $this->db->getConn()->prepare(Query::PLANET_BY_ID);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$res) {
                trigger_error('404: Planet does not exist');
            }

            return $this->convertToEntity($res);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            trigger_error('500: Error retrieving planet, try again later');
        }
    }

    public function save(Planet $planet): int
    {
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

            $id = $this->db->getConn()->lastInsertId() == 0 ? $planet->getId() : $this->db->getConn()->lastInsertId();
            return $id;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            trigger_error('500: Error saving planet, try again later');
        }
    }

    public function delete(int $id): void
    {
        try {
            $stmt = $this->db->getConn()->prepare(Query::DELETE_PLANET);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            trigger_error('500: Error deleting planet, try again later');
        }
    }

    private function convertToEntity(array $arr): Planet
    {
        $type = new EntityType($arr['type_id'], $arr['type_name']);
        return new Planet($arr['id'], $arr['name'], $type, $arr['size']);
    }
}
