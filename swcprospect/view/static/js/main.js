// load planets into the home table
function loadPlanets() {
    $('#planet-list').load('planets');
    $('#planet-data').html('<div></div>');
    $('#deposit-data').html('<div></div>');
}

$(function() {
    // call on page load
    loadPlanets();

    // when a planet is clicked load its data
    $(document).on('click', '.planet-name', function(e) {
        const id = $(e.currentTarget).attr('planet-id');
        $('#planet-data').load('planet/' + id);
    });

    // when a planet delete icon is clicked delete the planet
    $(document).on('click', '.planet-delete', function(e) {
        const id = $(e.currentTarget).attr('planet-id');

        $.ajax({
            url: '/planet/' + id,
            type: 'DELETE',
            success: function() {
                loadPlanets();
            }
        });
    });

    // when an empty planet cell is clicked show a warning
    $(document).on('click', '.grid-cell', function() {
        $('#deposit-data').html('<div class="alert alert-warning">No deposit recorded at this location!</div>')
    });

    // when a deposit cell is clicked load the deposit data
    $(document).on('click', '.grid-cell-deposit', function(e) {
        const id = $(e.currentTarget).attr('deposit-id');
        $('#deposit-data').load('deposit/' + id);
    });
});