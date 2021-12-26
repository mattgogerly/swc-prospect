<h3>
    Deposit @ <?= $deposit->getX() ?>, <?= $deposit->getY() ?> 
    <button type="button" class="btn btn-sm btn-primary" planet-id="<?= $deposit->getPlanetId() ?>" x="<?= $deposit->getX() ?>" y="<?= $deposit->getY() ?>" data-bs-toggle="modal" data-bs-target="#depositModal">
        <i class="bi bi-pencil"></i>
    </button>
    <button type="button" class="btn btn-sm btn-danger deposit-delete" planet-id="<?= $deposit->getPlanetId() ?>" x="<?= $deposit->getX() ?>" y="<?= $deposit->getY() ?>">
        <i class="bi bi-trash"></i>
    </button>
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