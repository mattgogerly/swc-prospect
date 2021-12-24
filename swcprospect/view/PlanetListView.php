<?php

namespace swcprospect\view;

class PlanetListView {

    public function render($planets): string {
        ob_start();
        include('templates/planet_list.php');
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}

?>