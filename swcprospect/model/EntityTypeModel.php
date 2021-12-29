<?php

namespace swcprospect\model;

use PDOException;
use swcprospect\model\db\Query;
use swcprospect\model\entity\EntityType;
use swcprospect\model\Model;

class EntityTypeModel extends Model
{
    public function getPlanetTypes(): array
    {
        return $this->getAll(Query::PLANET_TYPES);
    }

    public function getDepositTypes(): array
    {
        return $this->getAll(Query::DEPOSIT_TYPES);
    }

    public function getTileTypes(): array
    {
        return $this->getAll(Query::TILE_TYPES);
    }

    public function getAll(string $query): array
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
