<table class="table table-striped table-hover table-dark">
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Size</th>
        </tr>
    </thead>
    <tbody>

    <?php
    foreach ($planets as $planet) {
    ?>
        <tr class="planet">
            <td>
                <?= $planet->getName() ?>
            </td>
            <td>
                <?= $planet->getType()->getName() ?>
            </td>
            <td>
                <?= $planet->getSize() ?> x <?= $planet->getSize() ?>
            </td>
        </tr>
    <?php
    }
    ?>

    </tbody>
</table>