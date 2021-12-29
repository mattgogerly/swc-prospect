<?php

namespace swcprospect\view;

use swcprospect\model\entity\Planet;

/**
 * View of a Planet, including its grid of tiles and deposits.
 */
class PlanetView
{
    /**
     * rRender the PlanetView.
     *
     * @param Planet $planet Planet to display.
     *
     * @return string HTML of the view.
     */
    public function render(Planet $planet): string
    {
        ob_start();
        include('templates/planet.php');
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
