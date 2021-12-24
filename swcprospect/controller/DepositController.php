<?php

namespace swcprospect\controller;

use swcprospect\model\DepositModel;
use swcprospect\view\DepositView;

class DepositController {

    private DepositModel $model;

    public function __construct(DepositModel $model) {
        $this->model = $model;
    }

    public function deposit(int $planet, int $x, int $y): void {
        $deposit = $this->model->getByPlanetCoord($planet, $x, $y);
        $view = new DepositView();
        echo $view->render($deposit);
    }

    public function delete(int $id): void {
        $this->model->delete($id);
    }
}

?>