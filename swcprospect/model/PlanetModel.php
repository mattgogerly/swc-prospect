<?php

namespace swcprospect\model;

use swcprospect\model\Model;
use swcprospect\model\db\Query;

class PlanetModel extends Model {

    public function getAll() {
        try {
             return $this->db->getConn()->query(Query::GET_PLANETS);
        } catch (\PDOException $e) {
             return [];
        }
   }

   public function getById($id) {
        try {
             $stmt = $this->db->getConn->prepare(Query::GET_PLANET);
             $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
             $stmt->execute();

             return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
             return [];
        }
   }

    public function save(Planet $planet) {
        try {
            //
        } catch (\PDOException $e) {
            echo "";
        }
    }

    public function delete(int $id) {
        try {
            //
        } catch (\PDOException $e) {
            echo "";
        }
    }
}
?>