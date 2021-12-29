<?php
if (empty($deposits)) {
    ?>
<div class="alert alert-warning">
    No deposits recorded on this planet yet. Double click a tile to add one!
</div>
    <?php
} else {
    ?>

<h4>Deposits</h4>
<table class="table table-striped table-hover table-dark">
    <thead>
        <tr>
            <th>Type</th>
            <th>Size</th>
            <th>X, Y</th>
        </tr>
    </thead>

    <tbody>
    <?php
    foreach ($deposits as $deposit) {
        ?>
        <tr class="deposit-table-row">
            <td>
                <?= $deposit->getType()->getName() ?>
            </td>
            <td>
                <?= $deposit->getSize() ?>
            </td>
            <td>
                <?= $deposit->getX() ?>, <?= $deposit->getY() ?>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
    <?php
}
?>