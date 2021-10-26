<?php

for ($y = 0; $y < $planet->getSize(); $y++) {
    echo '<div class="row">';
    
    for ($x = 0; $x < $planet->getSize(); $x++) {
        echo '<div class="col grid-cell">';
        echo '</div>';
    }

    echo '</div>';
}

?>