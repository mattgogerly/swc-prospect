<?php

namespace swcprospect\model;

use swcprospect\model\Model;
use swcprospect\model\db\Query;
use swcprospect\model\entity\EntityType;
use PDOException;

class EntityTypeModel extends Model {

    public function getPlanetTypes() {
        return $this->getAll(Query::PLANET_TYPES);
    }

    public function getDepositTypes() {
        return $this->getAll(Query::DEPOSIT_TYPES);
    }

    public function getTileTypes() {
        return $this->getAll(Query::TILE_TYPES);
    }

    public function getAll(string $query) {
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
?>