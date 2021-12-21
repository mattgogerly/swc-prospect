<?php

namespace swcprospect\model;

use swcprospect\model\Model;
use swcprospect\model\db\Query;
use swcprospect\model\entity\DepositType;

class DepositTypeModel extends Model {

    public function getAll() {
        try {
            $res = $this->db->getConn()->query(Query::GET_DEPOSIT_TYPES);

            $types = [];
            foreach ($res as $t) {
                $type = new DepositType($t['id'], $t['name']);
                array_push($types, $type);
            }

            return $types;
        } catch (\PDOException $e) {
            return [];
        }
    }
}
?>