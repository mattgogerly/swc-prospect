$(document).ready(function() {
    $('div.planet').click(function(e) {
        e.preventDefault();
        $('#planet-grid').load('planet.php?' + $.param({id: 1}));
    });
});