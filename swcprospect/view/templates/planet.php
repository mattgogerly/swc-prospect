<?php
function getCellHtml($tile, $deposit) {
    $cellHtml = '';
    if ($tile != NULL) {
        $cellHtml = 'style="background-image: url(' . STATIC_ROOT . '/img/terrains/' . $tile->getId() . '.gif' . ');"';
    }

    if ($deposit != NULL) {
        $depositId = $deposit->getId();
        $cellHtml .= ' class="col grid-cell-deposit" deposit-id="' . $depositId . '"';
    } else {
        $cellHtml .= ' class="col grid-cell"';
    }

    return $cellHtml;
}

function renderCell($tile, $deposit) {
    echo '<div ' . getCellHtml($tile, $deposit) . ' >';

    if ($deposit != NULL) {
        $depositTypeId = $deposit->getType()->getId();
        echo '<img src="' . STATIC_ROOT . '/img/materials/' . $depositTypeId . '.gif" width="30" height="40" />';
    }

    echo '</div>';
}
?>

<div class="row">
    <div class="col">
    <?php
    for ($y = 0; $y < $planet->getSize(); $y++) {
        echo '<div class="row align-middle">';
        
        for ($x = 0; $x < $planet->getSize(); $x++) {
            $tile = $planet->getTileMap()[$y][$x];
            $deposit = $planet->getDepositMap()[$y][$x];

            renderCell($tile, $deposit);
        }

        echo '</div>';
    }
    ?>
    </div>
    
    <div class="col">
        <h3><?= $planet->getName() ?></h3>
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

        <div id="deposit-data">
            <div class="alert alert-info">
                Select a planet and grid cell to view deposit information.
            </div>
        </div>
    </div>
</>