<?php

namespace swcprospect\controller;

use swcprospect\model\DepositModel;
use swcprospect\view\DepositView;

class DepositController {

    private DepositModel $model;

    public function __construct(DepositModel $model) {
        $this->model = $model;
    }

    public function deposit(int $id): void {
        if (filter_var($id, FILTER_VALIDATE_INT) === false) {
            echo 'Invalid deposit ID provided';
            return;
        }

        $deposit = $this->model->getById($id);
        $view = new DepositView();
        echo $view->render($deposit);
    }

    public function delete(int $id): void {
        if (filter_var($id, FILTER_VALIDATE_INT) === false) {
            echo 'Invalid deposit ID provided';
            return;
        }

        $this->model->delete($id);
    }
}

?>