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
    <tr>
        <th scope="row">Edit</th>
        <td>
            <i class="bi bi-pencil action-icon deposit-update" planet-id="<?= $deposit->getPlanet() ?>" deposit-id="<?= $deposit->getId() ?>"></i>
        </td>
    </tr>
    <tr>
        <th scope="row">Delete</th>
        <td><i class="bi bi-trash action-icon deposit-delete" planet-id="<?= $deposit->getPlanet() ?>" deposit-id="<?= $deposit->getId() ?>"></i></td>
    </tr>
</table>

<?php
}
?>