// show an error toast with a given message
errorToast = message => {
    $('.toast-body').html(message);
    $('#errorToast').toast('show');
};

$(document).ajaxError((_event, request, _settings) => {
    // 404s are handled by views so no need to show an alert
    if (request.status !== 404) {
        errorToast(request.responseText);
    }
})

// utility to convert a HTML form to an object
formToObject = (id) => {
    return $(id).serializeArray()
        .reduce((accumObj, { name, value }) => { 
            return { ...accumObj, [name]: value ? value : null} 
        }, {});
};

// load planets into the home table and reset the planet-view
loadPlanets = () => {
    $('#planet-list').load('planets/view');
    $('#planet-view').html('<div></div>');
    $('#deposit-view').html('<div></div>');
};

// get deposit types and populate the dropdown in the deposit modal
loadTypes = type => {
    $.getJSON('type/' + type, types => {
        $.each(types, i => {
            $('#' + type + 'Type').append($('<option>', { 
                value: types[i].id, 
                text: types[i].name 
            }));
        });
    });
};

// loads a specific planet into view
loadPlanet = (id, callback) => {
    callback = callback || function(){};
    $('#planet-view').load('planet/' + id  + '/view', callback);
};

// saves a planet using the data submitted
savePlanet = () => {
    const data = formToObject('#planetForm');

    $.post('/planets', JSON.stringify(data), () => {
        loadPlanets();
        loadPlanet(data.id);
    });
};

// deletes a planet and then reloads the planets list
deletePlanet = id => {
    $.ajax({
        url: '/planet/' + id,
        type: 'DELETE',
        success: () => {
            loadPlanets();
        }
    });
};

// loads a deposit into view
loadDeposit = (planetId, x, y) => {
    $('#deposit-view').load('deposit/' + planetId + '/' + x + '/' + y + '/view');
};

// warning message for no deposits at a specific location
showNoDepositWarning = (planet, x, y) => {
    $('#deposit-view').html('<div class="alert alert-warning">No deposit recorded at this location!</div>')
};

// saves a deposit from the data submitted
saveDeposit = () => {
    const data = formToObject('#depositForm');
    const { planetId, x, y } = data;

    $.post('/deposits', JSON.stringify(data), () => {
        loadPlanet(planetId, () => loadDeposit(planetId, x, y));
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
};

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

// loads required data into the deposit modal, then fetches existing data and populates if it exists
loadDepositModalData = event => {
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
};

// when the deposit modal is opened load the key data and data for the current deposit if exists
$('#depositModal').on('show.bs.modal', event => loadDepositModalData(event));

$(() => {
    // load planets list on page load
    loadPlanets();

    // load types into modals
    loadTypes('planet');
    loadTypes('deposit');

    /*
     **** BINDINGS ****
     */

    // when a planet is clicked load its data and grid
    // delegated as rows are loaded dynamically
    $(document).on('click', '.planet-table-row', e => {
        const id = $(e.currentTarget).attr('planet-id');
        loadPlanet(id);
    });

    // save planet when form is submitted
    $('#planetFormSubmit').click(() => {
        savePlanet();
    });

    // when a planet delete icon is clicked delete the planet
    // delegated as button loaded dynamically
    $(document).on('click', '.planet-delete', e => {
        // stop propagation to prevent the click on the planet-table-row behind loading the 
        // planet that was just deleted
        e.stopPropagation();

        const id = $(e.currentTarget).attr('planet-id');
        deletePlanet(id);
    });

    // when a grid cell is double clicked show the deposit modal
    // delegated as grid cells loaded dynamically
    $(document).on('dblclick', '.grid-cell', e => {
        const modal = new bootstrap.Modal(document.getElementById('depositModal'));
        modal.show(e.currentTarget);
    });

    // when an empty planet cell is clicked show a warning
    // delegated as grid cells loaded dynamically
    $(document).on('click', '.grid-cell-no-deposit', () => {
        showNoDepositWarning();
    });

    // when a deposit cell is clicked load the deposit data
    // delegated as grid cells loaded dynamically
    $(document).on('click', '.grid-cell-deposit', e => {
        const planet = $(e.currentTarget).attr('planet-id');
        const x = $(e.currentTarget).attr('x');
        const y = $(e.currentTarget).attr('y');
        loadDeposit(planet, x, y);
    });

    // save deposit when form is submitted
    $('#depositFormSubmit').click(() => {
        saveDeposit();
    });

    // when a deposit delete icon is clicked delete the deposit
    // delegated as delete button loaded dynamicaly
    $(document).on('click', '.deposit-delete', e => {
        const planetId = $(e.currentTarget).attr('planet-id');
        const x = $(e.currentTarget).attr('x');
        const y = $(e.currentTarget).attr('y');
        deleteDeposit(planetId, x, y);
    });
});