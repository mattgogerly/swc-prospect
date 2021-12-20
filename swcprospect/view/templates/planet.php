<div class="row">
    <div class="col">
    <?php

    for ($y = 0; $y < $planet->getSize(); $y++) {
        echo '<div class="row align-middle">';
        
        for ($x = 0; $x < $planet->getSize(); $x++) {
            $deposit = $planet->getDepositMap()[$y][$x];

            if ($deposit != NULL) {
                $depositId = $deposit->getId();
                $depositType = $deposit->getType()->getId();

                echo '<div class="col grid-cell-deposit" deposit-id=' . $depositId . '>';
                echo '<img src="https://img.swcombine.com//materials/' . $depositType . '/deposit.gif" width="30" height="40" />';
                echo '</div>';
            } else {
                echo '<div class="col grid-cell"></div>';
            }
        }

        echo '</div>';
    }

    ?>
    </div>
    
    <div class="col">
        <h3><?php echo $planet->getName() ?></h3>
        <table class="table table-dark table-striped">
            <tr class="align-middle">
                <th scope="row">Image</th>
                <td><img src="https://img.swcombine.com//galaxy/planets/<? echo $planet->getType()->getId() ?>/main.gif"></td>
            </tr>
            <tr>
                <th scope="row">Type</th>
                <td><? echo $planet->getType()->getName() ?></td>
            </tr>
            <tr>
                <th scope="row">Size</th>
                <td><? echo $planet->getSize() ?> x <? echo $planet->getSize() ?></td>
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
</div>