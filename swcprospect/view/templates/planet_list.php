<table class="table table-striped table-hover table-dark">
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Size</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>

    <?php
    foreach ($planets as $planet) {
    ?>
        <tr>
            <td class="planet-name" planet-id="<?= $planet->getId() ?>">
                <?= $planet->getName() ?>
            </td>
            <td>
                <?= $planet->getType()->getName() ?>
            </td>
            <td>
                <?= $planet->getSize() ?> x <?= $planet->getSize() ?>
            </td>
            <td>
                <i class="bi bi-pencil planet-update" planet-id="<?= $planet->getId() ?>"></i>
            </td>
            <td>
                <i class="bi bi-trash planet-delete" planet-id="<?= $planet->getId() ?>"></i>
            </td>
        </tr>
    <?php
    }
    ?>

    </tbody>
</table>