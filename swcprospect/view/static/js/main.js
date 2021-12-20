$(function() {
    // load planets into the table
    $('#planet-list').load('planets');

    // when a planet is clicked load its data
    $(document).on('click', '.planet', function() {
        $('#planet-data').load('planet/1');
    });

    // when an empty planet cell is clicked show a warning
    $(document).on('click', '.grid-cell', function(e) {
        $('#deposit-data').html('<div class="alert alert-warning">No deposit recorded at this location!</div>')
    });

    // when a deposit cell is clicked load the deposit data
    $(document).on('click', '.grid-cell-deposit', function(e) {
        const id = $(e.currentTarget).attr('deposit-id');
        $('#deposit-data').load('deposit/' + id);
    });
});