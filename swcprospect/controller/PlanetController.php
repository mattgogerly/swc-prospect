<?php

namespace swcprospect\controller;

use swcprospect\model\PlanetModel;
use swcprospect\view\PlanetListView;
use swcprospect\view\PlanetGridView;

class PlanetController {

    private $model;

    public function __construct(PlanetModel $model) {
        $this->model = $model;
    }

    public function planets() {
        $planets = $this->model->getAll();
        $view = new PlanetListView();
        return $view->render($planets);
    }

    public function planetGrid() {
        $planet_id = $_GET['id'];
        if (filter_var($planet_id, FILTER_VALIDATE_INT) === false) {
            echo 'Invalid planet ID provided';
            return;
        }

        $planet = $this->model->getById($planet_id);
        $view = new PlanetGridView();
        return $view->render($planet);
    }
}

?>