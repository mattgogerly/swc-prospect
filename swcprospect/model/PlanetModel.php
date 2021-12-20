<?php

namespace swcprospect\model;

use swcprospect\model\Model;
use swcprospect\model\db\Query;
use swcprospect\model\entity\Planet;
use swcprospect\model\entity\PlanetType;

class PlanetModel extends Model {

    public function getAll() {
        try {
            $res = $this->db->getConn()->query(Query::GET_PLANETS);
            
            $planets = [];
            foreach ($res as $p) {
                $type = new PlanetType($p['type_id'], $p['type_name']);
                $planet = new Planet($p['id'], $p['name'], $type, $p['size']);
                array_push($planets, $planet);
            }

            return $planets;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return [];
        }
   }

   public function getById($id) {
        try {
            $stmt = $this->db->getConn()->prepare(Query::GET_PLANET);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetch(\PDO::FETCH_ASSOC);

            $type = new PlanetType($res['type_id'], $res['type_name']);
            return new Planet($res['id'], $res['name'], $type, $res['size']);
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

    public function delete(int $id) {
        try {
            //
        } catch (\PDOException $e) {
            echo "";
        }
    }
}
?>