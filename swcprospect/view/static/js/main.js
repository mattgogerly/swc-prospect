// get planet types and populate the dropdown in the planets modal
function loadPlanetTypes() {
    $.getJSON('type/planet', function(types) {
        $.each(types, function(i) {
            $('#planetType').append($('<option>', { 
                value: types[i].id, 
                text: types[i].name 
            }));
        });
    });
}

// when the planet modal is opened load the planet types, and load the data for the 
// current planet if editing
$('#planetModal').on('shown.bs.modal', function(event) {
    loadPlanetTypes();

    const clickedElement = event.relatedTarget;
    const planetId = clickedElement.getAttribute('planet-id');
    if (planetId) {
        $.getJSON('planet/' + planetId, function(planet) {
            $('#planetId').val(planet.id);
            $('#planetName').val(planet.name);
            $('#planetType').val(planet.type.id).change();
            $('#planetSize').val(planet.size);
        });
    }
});

// load planets into the home table and reset the planet-view
function loadPlanets() {
    $('#planet-list').load('planets/view');
    $('#planet-view').html('<div></div>');
    $('#deposit-view').html('<div></div>');
}

// loads a specific planet into view
function loadPlanet(id) {
    $('#planet-view').load('planet/' + id  + '/view');
}

// warning message for no deposits at a specific location
function showNoDepositWarning() {
    $('#deposit-view').html('<div class="alert alert-warning">No deposit recorded at this location!</div>')
}

// deletes a planet and then reloads the planets list
function deletePlanet(id) {
    $.ajax({
        url: '/planet/' + id,
        type: 'DELETE',
        success: function() {
            loadPlanets();
        }
    });
}

// deletes a deposit and then reloads the current planet view
function deleteDeposit(depositId, planetId) {
    $.ajax({
        url: '/deposit/' + depositId,
        type: 'DELETE',
        success: function() {
            loadPlanet(planetId);
        }
    });
}

$(function() {
    // load planets list on page load
    loadPlanets();

    // when a planet is clicked load its data and grid
    $(document).on('click', '.planet-table-row', function(e) {
        const id = $(e.currentTarget).attr('planet-id');
        loadPlanet(id);
    });

    // when a planet delete icon is clicked delete the planet
    $(document).on('click', '.planet-delete', function(e) {
        // stop propagation to prevent loading the planet that was just deleted
        e.stopPropagation();

        const id = $(e.currentTarget).attr('planet-id');
        deletePlanet(id);
    });

    // when a deposit delete icon is clicked delete the deposit
    $(document).on('click', '.deposit-delete', function(e) {
        const depositId = $(e.currentTarget).attr('deposit-id');
        const planetId = $(e.currentTarget).attr('planet-id');
        deleteDeposit(depositId, planetId);
    });

    // when an empty planet cell is clicked show a warning
    $(document).on('click', '.grid-cell', function() {
        showNoDepositWarning();
    });

    // when a deposit cell is clicked load the deposit data
    $(document).on('click', '.grid-cell-deposit', function(e) {
        const id = $(e.currentTarget).attr('deposit-id');
        $('#deposit-view').load('deposit/' + id + '/view');
    });
});