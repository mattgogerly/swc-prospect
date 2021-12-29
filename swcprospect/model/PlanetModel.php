<?php

namespace swcprospect\model;

use PDO;
use PDOException;
use swcprospect\model\db\Query;
use swcprospect\model\entity\EntityType;
use swcprospect\model\entity\Planet;
use swcprospect\model\Model;

/**
 * PlanetModel is a wrapper for manipulating Planets in the DB.
 */
class PlanetModel extends Model
{
    /**
     * Retrieves a list of all Planetseposit from the DB by Planet and X, Y coord.
     * @see Planet
     *
     * @return array array of Planet objects.
     */
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

    /**
     * Retrieves a Planet from the DB by ID.
     * @see Planet
     *
     * @param int $id the ID of the Planet.
     *
     * @return Planet Planet object.
     * @throws 404 if not found.
     */
    public function getById($id): Planet
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

    /**
     * Saves a Planet to the DB.
     * @see Planet
     *
     * @param Planet $planet Planet object to be saved.
     *
     * @return void
     */
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

    /**
     * Deletes a specific Planet from the DB.
     * @see Planet
     *
     * @param int $id the Planet ID to delete.
     *
     * @return void
     */
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

    /**
     * Utility to convert a row from the DB to a Planet object.
     * @see Planet
     *
     * @param array $arr Array of data from the DB containing fields for a Planet.
     *
     * @return Planet Planet object from the data in the DB.
     */
    private function convertToEntity(array $arr): Planet
    {
        $type = new EntityType($arr['type_id'], $arr['type_name']);
        return new Planet($arr['id'], $arr['name'], $type, $arr['size']);
    }
}
