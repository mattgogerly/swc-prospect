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
    Deposit @ <? echo $deposit->getX() ?>, <? echo $deposit->getY() ?>
</h3>

<table class="table table-dark table-striped">
    <tr class="align-middle">
        <th scope="row">Type</th>
        <td><? echo $deposit->getType()->getName() ?></td>
    </tr>
    <tr>
        <th scope="row">Size</th>
        <td><? echo $deposit->getSize() ?></td>
    </tr>
</table>

<?php
}
?>