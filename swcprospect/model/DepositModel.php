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
            $stmt = $this->db->getConn()->prepare(Query::DEPOSIT_BY_COORD);
            $stmt->bindValue(':planetId', $planet, PDO::PARAM_INT);
            $stmt->bindValue(':x', $x, PDO::PARAM_INT);
            $stmt->bindValue(':y', $y, PDO::PARAM_INT);
            $stmt->execute();

            $res = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$res) {
                trigger_error('404: Deposit does not exist');
            }

            return $this->convertToEntity($res);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            trigger_error('500: Error retrieving deposit, try again later');
        }
    }

    public function getByPlanet(int $planetId): array {
        try {
            $stmt = $this->db->getConn()->prepare(Query::DEPOSITS_BY_PLANET);
            $stmt->bindValue(':planetId', $planetId, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $depositList = array();
            foreach ($res as $d) {
                array_push($depositList, $this->convertToEntity($d));
            }

            return $depositList;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            trigger_error('500: Error retrieving deposits, try again later');
        }
    }

    public function save(Deposit $deposit): void {
        try {
            $stmt = $this->db->getConn()->prepare(Query::SAVE_DEPOSIT);
            
            $stmt->bindValue(':planetId', $deposit->getPlanetId(), PDO::PARAM_INT);
            $stmt->bindValue(':x', $deposit->getX(), PDO::PARAM_INT);
            $stmt->bindValue(':y', $deposit->getY(), PDO::PARAM_INT);
            $stmt->bindValue(':type', $deposit->getType()->getId(), PDO::PARAM_INT);
            $stmt->bindValue(':size', $deposit->getSize(), PDO::PARAM_INT);

            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            trigger_error('500: Error saving deposit, try again later');
        }
    }

    public function delete(int $planetId, int $x, int $y): void {
        try {
            $stmt = $this->db->getConn()->prepare(Query::DELETE_DEPOSIT);
            $stmt->bindValue(':planetId', $planetId, PDO::PARAM_INT);
            $stmt->bindValue(':x', $x, PDO::PARAM_INT);
            $stmt->bindValue(':y', $y, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            trigger_error('500: Error deleting deposit, try again later');
        }
    }

    public function deleteByPlanet(int $planetId): void {
        try {
            $stmt = $this->db->getConn()->prepare(Query::DELETE_DEPOSITS);
            $stmt->bindValue(':planetId', $planetId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            trigger_error('500: Error deleting deposits, try again later');
        }
    }

    private function convertToEntity($arr): Deposit {
        $type = new EntityType($arr['type_id'], $arr['type_name']);
        return new Deposit($arr['planet'], $arr['x'], $arr['y'], $type, $arr['size']);
    }
}
?>