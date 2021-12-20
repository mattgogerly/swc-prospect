<?php

if ($deposit == null) {
?>

<div class="alert alert-danger">
    Error fetching deposit data
</div>

<?php
} else {
?>

<h3>
    Deposit @ <?= $deposit->getX() ?>, <?= $deposit->getY() ?>
</h3>

<table class="table table-dark table-striped">
    <tr class="align-middle">
        <th scope="row">Type</th>
        <td><?= $deposit->getType()->getName() ?></td>
    </tr>
    <tr>
        <th scope="row">Size</th>
        <td><?= $deposit->getSize() ?></td>
    </tr>
</table>

<?php
}
?>