<?php

namespace swcprospect\view;

class PlanetView {

    public function render($planet) {
        ob_start();
        include('templates/planet.php');
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
    
}

?>