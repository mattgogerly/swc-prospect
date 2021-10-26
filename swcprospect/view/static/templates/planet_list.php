<?php
include 'html/header.html';
?>

<div id="planet-list" class="container">
    <div class="row">
        <div class="col">
            Name
        </div>
        <div class="col">
            Type
        </div>
        <div class="col">
            Size
        </div>
    </div>

    <?php
        foreach ($planets as $planet) {
    ?>
        <div class="row planet">
            <div class="col">
                <? echo $planet['name'] ?>
            </div>
            <div class="col">
                <? echo $planet['type'] ?>
            </div>
            <div class="col">
                <? echo $planet['size'] ?>
            </div>
        </div>
    <?php
        }
    ?>
</div>

<div id="planet-grid" class="container-sm">
</div>

<?php
include 'html/footer.html';
?>