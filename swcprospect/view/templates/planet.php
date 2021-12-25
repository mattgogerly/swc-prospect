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
        echo '<img src="' . STATIC_ROOT . '/img/materials/' . $deposit->getType()->getId() . '.gif" width="15" height="30" />';
    }

    echo '</div>';
}
?>

<div class="row">
    <div class="col">
    <?php
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
    </div>
    
    <div class="col">
        <h3>
            <?= $planet->getName() ?>
            <button type="button" class="btn btn-sm btn-primary" planet-id="<?= $planet->getId() ?>" data-bs-toggle="modal" data-bs-target="#planetModal">
                <i class="bi bi-pencil"></i>
            </button>
        </h3>

        <table class="table table-dark table-striped">
            <tr class="align-middle">
                <th scope="row">Image</th>
                <td><img src="<?= STATIC_ROOT . '/img/planets/'. $planet->getType()->getId() ?>.gif"></td>
            </tr>
            <tr>
                <th scope="row">Type</th>
                <td><?= $planet->getType()->getName() ?></td>
            </tr>
            <tr>
                <th scope="row">Size</th>
                <td><?= $planet->getSize() ?> x <?= $planet->getSize() ?></td>
            </tr>
            <tr>
                <th scope="row"># Deposits</th>
                <td>0</td>
            </tr>
        </table>

        <div id="deposit-view">
            <div class="alert alert-info">
                Select a grid cell to view deposit information.
            </div>
        </div>
    </div>
</div>