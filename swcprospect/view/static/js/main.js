// load planets into the home table and reset the planet-view
loadPlanets = () => {
    $('#planet-list').load('planets/view');
    $('#planet-view').html('<div></div>');
    $('#deposit-view').html('<div></div>');
}

// get deposit types and populate the dropdown in the deposit modal
loadTypes = (type) => {
    $.getJSON('type/' + type, types => {
        $.each(types, i => {
            $('#' + type + 'Type').append($('<option>', { 
                value: types[i].id, 
                text: types[i].name 
            }));
        });
    });
}

// loads a specific planet into view
loadPlanet = (id) => {
    $('#planet-view').load('planet/' + id  + '/view');
}

// when the planet modal is opened load the planet types, and load the data for the 
// current planet if editing
$('#planetModal').on('show.bs.modal', event => {
    const clickedElement = event.relatedTarget;
    const planetId = clickedElement.getAttribute('planet-id');

    if (planetId) {
        $.getJSON('planet/' + planetId, planet => {
            $('#planetId').val(planet.id);
            $('#planetName').val(planet.name);
            $('#planetType').val(planet.type.id).change();
            $('#planetSize').val(planet.size);
        });
    }
});

savePlanet = () => {
    const data = $('#planetForm').serializeArray()
        .reduce((accumObj, { name, value }) => { 
            return { ...accumObj, [name]: value ? value : null} 
        }, {});

    $.post('/planets', JSON.stringify(data), () => {
        loadPlanets();
    });
}

// deletes a planet and then reloads the planets list
deletePlanet = (id) => {
    $.ajax({
        url: '/planet/' + id,
        type: 'DELETE',
        success: () => {
            loadPlanets();
        }
    });
}

loadDeposit = (planetId, x, y) => {
    $('#deposit-view').load('deposit/' + planetId + '/' + x + '/' + y + '/view');
};

// warning message for no deposits at a specific location
showNoDepositWarning = (planet, x, y) => {
    $('#deposit-view').html('<div class="alert alert-warning">No deposit recorded at this location!</div>')
}

// when the deposit modal is opened load the planet types, and load the data for the 
// current planet if editing
$('#depositModal').on('show.bs.modal', event => {
    const clickedElement = event.relatedTarget;

    const planetId = clickedElement.getAttribute('planet-id');
    const x = clickedElement.getAttribute('x');
    const y = clickedElement.getAttribute('y');

    $('#depositPlanetId').val(planetId);
    $('#x').val(x);
    $('#y').val(y);

    $.getJSON('deposit/' + planetId + '/' + x + '/' + y, deposit => {
        $('#depositType').val(deposit.type.id).change();
        $('#depositSize').val(deposit.size);
    });
});

saveDeposit = () => {
    const data = $('#depositForm').serializeArray()
        .reduce((accumObj, { name, value }) => { 
            return { ...accumObj, [name]: value ? value : null} 
        }, {});

    const { planetId, x, y } = data;

    $.post('/deposits', JSON.stringify(data), () => {
        loadDeposit(planetId, x, y);
    });
}

// deletes a deposit and then reloads the current planet view
deleteDeposit = (planetId, x, y) => {
    $.ajax({
        url: '/deposit/' + planetId + '/' + x + '/' + y,
        type: 'DELETE',
        success: () => {
            loadPlanet(planetId);
        }
    });
}

$(() => {
    // load planets list on page load
    loadPlanets();

    // load types into modals
    loadTypes('planet');
    loadTypes('deposit');

    // when a planet is clicked load its data and grid
    $(document).on('click', '.planet-table-row', e => {
        const id = $(e.currentTarget).attr('planet-id');
        loadPlanet(id);
    });

    // save planet when form is submitted
    $('#planetFormSubmit').click(() => {
        savePlanet();
    });

    // when a planet delete icon is clicked delete the planet
    $(document).on('click', '.planet-delete', e => {
        // stop propagation to prevent loading the planet that was just deleted
        e.stopPropagation();

        const id = $(e.currentTarget).attr('planet-id');
        deletePlanet(id);
    });

    // save deposit when form is submitted
    $('#depositFormSubmit').click(() => {
        saveDeposit();
    });

    // when an empty planet cell is clicked show a warning
    $(document).on('click', '.grid-cell', () => {
        showNoDepositWarning();
    });

    // when a deposit cell is clicked load the deposit data
    $(document).on('click', '.grid-cell-deposit', e => {
        const planet = $(e.currentTarget).attr('planet');
        const x = $(e.currentTarget).attr('x');
        const y = $(e.currentTarget).attr('y');
        loadDeposit(planet, x, y);
    });

    // when a deposit delete icon is clicked delete the deposit
    $(document).on('click', '.deposit-delete', e => {
        const planetId = $(e.currentTarget).attr('planet-id');
        const x = $(e.currentTarget).attr('x');
        const y = $(e.currentTarget).attr('y');
        deleteDeposit(planetId, x, y);
    });
});