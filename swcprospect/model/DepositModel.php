<?php

namespace swcprospect\model;

use swcprospect\model\Model;
use swcprospect\model\db\Query;
use swcprospect\model\entity\Deposit;
use PDO;
use PDOException;

class DepositModel extends Model {

    public function getByPlanetCoord(int $planet, int $x, int $y): Deposit {
        try {
            $stmt = $this->db->getConn()->prepare(Query::GET_DEPOSIT);
            $stmt->bindValue(':planetId', $planet, PDO::PARAM_INT);
            $stmt->bindValue(':x', $x, PDO::PARAM_INT);
            $stmt->bindValue(':y', $y, PDO::PARAM_INT);
            $stmt->execute();

            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $this->convertToEntity($res);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getByPlanet(int $planetId): array {
        try {
            $stmt = $this->db->getConn()->prepare(Query::GET_DEPOSITS_BY_PLANET);
            $stmt->bindValue(':planetId', $planetId, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $depositList = array();
            foreach ($res as $d) {
                array_push($depositList, $this->convertToEntity($d));
            }

            return $depositList;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function save(Deposit $deposit) {
        try {
            //
        } catch (PDOException $e) {
            echo "";
        }
    }

    public function delete(int $id) {
        try {
            $stmt = $this->db->getConn()->prepare(Query::DELETE_DEPOSIT);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "";
        }
    }

    public function deleteByPlanet(int $planetId): void {
        try {
            $stmt = $this->db->getConn()->prepare(Query::DELETE_DEPOSITS_BY_PLANET);
            $stmt->bindValue(':planetId', $planetId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "";
        }
    }

    private function convertToEntity($arr): Deposit {
        return new Deposit($arr['id'], $arr['type_id'], $arr['planet'], $arr['x'], $arr['y'], $arr['size']);
    }
}
?>