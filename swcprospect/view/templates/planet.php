<div class="row">
    <div class="col">
        <?php
        include('planet_grid.php');
        ?>
    </div>
    
    <div class="col">
        <h3>
            <?= $planet->getName() ?>
            <button type="button" class="btn btn-sm btn-primary" planet-id="<?= $planet->getId() ?>" data-bs-toggle="modal" data-bs-target="#planetModal">
                <i class="bi bi-pencil"></i>
            </button>
        </h3>

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
        </table>

        <div id="deposit-view">
            <!-- loaded dynamically -->
        </div>
    </div>
</div>