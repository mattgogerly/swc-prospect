<?php

namespace swcprospect\view;

/**
 * List of Planets in a table. Shows type and size, and a button to delete.
 */
class PlanetListView
{
    /**
     * Render the PlanetListView.
     *
     * @param array $planets Planets to list.
     *
     * @return string HTML of the view.
     */
    public function render(array $planets): string
    {
        ob_start();
        include('templates/planet_list.php');
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
