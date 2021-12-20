<?php

namespace swcprospect\view;

class HomeView {

    public function render() {
        ob_start();
        include('templates/home.php');
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}

?>