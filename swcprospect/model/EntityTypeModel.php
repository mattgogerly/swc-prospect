<?php

namespace swcprospect\model;

use PDOException;
use swcprospect\model\db\Query;
use swcprospect\model\entity\EntityType;
use swcprospect\model\Model;

/**
 * EntityTypeModel is a wrapper for manipulating EntityTypes in the DB.
 */
class EntityTypeModel extends Model
{
    /**
     * Retrieves a list of Planet atmosphere types.
     *
     * @return array array of EntityTypes representing atmospheres.
     */
    public function getPlanetTypes(): array
    {
        return $this->getAll(Query::PLANET_TYPES);
    }

    /**
     * Retrieves a list of Deposit material types.
     *
     * @return array array of EntityTypes representing materials.
     */
    public function getDepositTypes(): array
    {
        return $this->getAll(Query::DEPOSIT_TYPES);
    }

    /**
     * Retrieves a list of Tile terrain types.
     *
     * @return array array of EntityTypes representing terrains.
     */
    public function getTileTypes(): array
    {
        return $this->getAll(Query::TILE_TYPES);
    }

    /**
     * Utility to retrieve data for a specific type.
     *
     * @param string Query to run against DB.
     *
     * @return array array of EntityTypes.
     */
    private function getAll(string $query): array
    {
        try {
            $res = $this->db->getConn()->query($query);

            $types = [];
            foreach ($res as $t) {
                $type = new EntityType($t['id'], $t['name']);
                array_push($types, $type);
            }

            return $types;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            trigger_error('500: Error retrieving types, try again later');
        }
    }
}
