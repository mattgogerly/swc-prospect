<?php
function getCellHtml($planetId, $x, $y, $tile, $deposit) {
    $cellHtml = 'planet-id="' . $planetId . '" x="' . $x . '" y="' . $y . '"';

    if ($tile != NULL) {
        $cellHtml .= ' style="background-image: url(' . STATIC_ROOT . '/img/terrains/' . $tile->getType()->getId() . '.gif' . ');"';
    }

    if ($deposit != NULL) {
        $cellHtml .= ' class="grid-cell grid-cell-deposit"';
    } else {
        $cellHtml .= ' class="grid-cell grid-cell-no-deposit"';
    }

    return $cellHtml;
}

function renderCell($planetId, $x, $y, $tile, $deposit) {
    echo '<div ' . getCellHtml($planetId, $x, $y, $tile, $deposit) . ' >';

    if ($deposit != NULL) {
        echo '<img src="' . STATIC_ROOT . '/img/materials/' . $deposit->getType()->getId() . '.gif" class="deposit-icon" />';
    }

    echo '</div>';
}

for ($y = 0; $y < $planet->getSize(); $y++) {
    echo '<div class="row grid-row">';

    for ($x = 0; $x < $planet->getSize(); $x++) {
        $tile = $planet->getTileMap()[$y][$x];
        $deposit = $planet->getDepositMap()[$y][$x];

        renderCell($planet->getId(), $x, $y, $tile, $deposit);
    }

    echo '</div>';
}
?>

