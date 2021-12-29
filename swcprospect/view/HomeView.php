<?php

namespace swcprospect\view;

/**
 * Home view. Shows containers for other content.
 */
class HomeView
{
    /**
     * Render the HomeView.
     *
     * @return string HTML of the view.
     */
    public function render(): string
    {
        ob_start();
        include('templates/home.php');
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
