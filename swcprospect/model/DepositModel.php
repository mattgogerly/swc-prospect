<?php

namespace swcprospect\model;

use swcprospect\model\Model;
use swcprospect\model\db\Query;
use swcprospect\model\entity\Deposit;
use swcprospect\model\entity\EntityType;
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
            echo $e;
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
            echo $e;
            return null;
        }
    }

    public function save(Deposit $deposit) {
        try {
            $stmt = $this->db->getConn()->prepare(Query::SAVE_DEPOSIT);
            
            $stmt->bindValue(':planetId', $deposit->getPlanet(), PDO::PARAM_INT);
            $stmt->bindValue(':x', $deposit->getX(), PDO::PARAM_INT);
            $stmt->bindValue(':y', $deposit->getY(), PDO::PARAM_INT);
            $stmt->bindValue(':type', $deposit->getType()->getId(), PDO::PARAM_INT);
            $stmt->bindValue(':size', $deposit->getSize(), PDO::PARAM_INT);

            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function delete(int $planetId, int $x, int $y) {
        try {
            $stmt = $this->db->getConn()->prepare(Query::DELETE_DEPOSIT);
            $stmt->bindValue(':planetId', $planetId, PDO::PARAM_INT);
            $stmt->bindValue(':x', $x, PDO::PARAM_INT);
            $stmt->bindValue(':y', $y, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function deleteByPlanet(int $planetId): void {
        try {
            $stmt = $this->db->getConn()->prepare(Query::DELETE_DEPOSITS_BY_PLANET);
            $stmt->bindValue(':planetId', $planetId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    private function convertToEntity($arr): Deposit {
        $type = new EntityType($arr['type_id'], $arr['type_name']);
        return new Deposit($arr['planet'], $arr['x'], $arr['y'], $type, $arr['size']);
    }
}
?>