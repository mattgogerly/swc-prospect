<table class="table table-striped table-hover table-dark">
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Size</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>

    <?php
    foreach ($planets as $planet) {
    ?>
        <tr class="planet-row" planet-id="<?= $planet->getId() ?>">
            <td>
                <?= $planet->getName() ?>
            </td>
            <td>
                <?= $planet->getType()->getName() ?>
            </td>
            <td>
                <?= $planet->getSize() ?> x <?= $planet->getSize() ?>
            </td>
            <td>
                <i class="bi bi-trash action-icon planet-delete" planet-id="<?= $planet->getId() ?>"></i>
            </td>
        </tr>
    <?php
    }
    ?>

    </tbody>
</table>