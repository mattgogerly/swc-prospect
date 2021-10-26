<?php

namespace swcprospect\view;

use swcprospect\model\entity\Planet;

class PlanetGridView {

    public function render(Planet $planet) {
        ob_start();
        include('templates/planet_grid.php');
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
    
}

?>