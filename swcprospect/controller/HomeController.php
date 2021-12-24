<?php

namespace swcprospect\controller;

use swcprospect\view\HomeView;

class HomeController {

    public function home(): void {
        $view = new HomeView();
        echo $view->render();
    }

}
?>