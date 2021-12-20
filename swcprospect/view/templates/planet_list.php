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
                <? echo $planet->getName() ?>
            </td>
            <td>
                <? echo $planet->getType()->getName() ?>
            </td>
            <td>
                <? echo $planet->getSize() ?> x <? echo $planet->getSize() ?>
            </td>
        </tr>
    <?php
    }
    ?>

    </tbody>
</table>