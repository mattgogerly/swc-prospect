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

    public function depositListView(int $planet): void {
        $deposits = $this->model->getByPlanet($planet);
        $view = new DepositListView();
        echo $view->render($deposits);
    }

    public function depositJson(int $planet, int $x, int $y) {
        echo json_encode($this->model->getByPlanetCoord($planet, $x, $y));
    }

    public function deposit(int $planet, int $x, int $y): void {
        $deposit = $this->model->getByPlanetCoord($planet, $x, $y);
        $view = new DepositView();
        echo $view->render($deposit);
    }

    public function save(int $planetId, int $x, int $y, int $type, int $size) {
        $deposit = new Deposit($planetId, $x, $y, new EntityType($type), $size);
        $this->model->save($deposit);
    }

    public function delete(int $planet, int $x, int $y): void {
        $this->model->delete($planet, $x, $y);
    }
}

?>