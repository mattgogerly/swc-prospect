<?php
include 'header.php';
?>

<div id="planet-list" class="container text-center"></div>

<div class="container text-center">
    <div id="planet-view">
        <div class="alert alert-info">
            No planets loaded.
        </div>
    </div>
</div>

<?php
include 'toast.html';
include 'planet_modal.php';
include 'deposit_modal.html';
include 'footer.php';
?>