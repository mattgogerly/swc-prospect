<?php

namespace swcprospect\controller;

use swcprospect\view\HomeView;

/**
 * Controller for rendering main view.
 */
class HomeController {

    /**
     * Renders the main view.
     * 
     * @return string main SWC Prospect view containing other components.
     */
    public function home(): string {
        $view = new HomeView();
        return $view->render();
    }

}
?>