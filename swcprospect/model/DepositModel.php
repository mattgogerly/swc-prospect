<?php

namespace swcprospect\model;

use swcprospect\model\Model;
use swcprospect\model\db\Query;
use swcprospect\model\entity\Deposit;
use PDO;
use PDOException;

class DepositModel extends Model {

    public function getById(int $id): Deposit {
        try {
            $stmt = $this->db->getConn()->prepare(Query::GET_DEPOSIT);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);

            return $this->convertToEntity($res);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getDepositMapForPlanet(int $planetId, int $planetSize): array {
        try {
            $stmt = $this->db->getConn()->prepare(Query::GET_DEPOSITS_BY_PLANET);
            $stmt->bindValue(':planetId', $planetId, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // init map to NULL
            $depositMap = array_fill(0, $planetSize, array_fill(0, $planetSize, NULL));

            // set IDs for deposists in map
            foreach ($res as $d) {
                $depositMap[$d['y']][$d['x']] = $this->convertToEntity($d);
            }

            return $depositMap;
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