<?php

namespace swcprospect\controller;

use swcprospect\model\entity\Deposit;
use swcprospect\model\entity\EntityType;
use swcprospect\model\DepositModel;
use swcprospect\view\DepositListView;
use swcprospect\view\DepositView;

class DepositController {

    private DepositModel $model;

    public function __construct(DepositModel $model) {
        $this->model = $model;
    }

    public function depositListView(int $planetId): void {
        $deposits = $this->model->getByPlanet($planetId);
        $view = new DepositListView();
        echo $view->render($deposits);
    }

    public function depositJson(int $planetId, int $x, int $y) {
        echo json_encode($this->model->getByPlanetCoord($planetId, $x, $y));
    }

    public function deposit(int $planetId, int $x, int $y): void {
        $deposit = $this->model->getByPlanetCoord($planetId, $x, $y);
        $view = new DepositView();
        echo $view->render($deposit);
    }

    public function save(int $planetId, int $x, int $y, int $type, int $size) {
        $deposit = new Deposit($planetId, $x, $y, new EntityType($type), $size);
        $this->model->save($deposit);
    }

    public function delete(int $planetId, int $x, int $y): void {
        $this->model->delete($planetId, $x, $y);
    }
}

?>