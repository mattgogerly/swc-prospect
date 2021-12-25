const planetModal = new bootstrap.Modal(document.getElementById('planetModal'));
const depositModal = new bootstrap.Modal(document.getElementById('depositModal'));

// show an error toast with a given message
errorToast = message => {
    $('.toast-body').html(message);
    $('#errorToast').toast('show');
};

// global error handler for AJAX errors
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
            console.log(name, value);
            return { ...accumObj, [name]: value ? value : null} 
        }, {});
};

// utility to get the planetId, x and y from an event
getEntityAttrs = event => {
    const clickedElement = event.relatedTarget || event.currentTarget;
    const planetId = clickedElement.getAttribute('planet-id');
    const x = clickedElement.getAttribute('x');
    const y = clickedElement.getAttribute('y');

    return { planetId, x, y };
}

resetForm = (id) => {
    $(id)[0].reset();
}

// get a list of types and populate the dropdown in the respective modal
loadTypes = type => {
    $.getJSON('/type/' + type, types => {
        $.each(types, i => {
            $('#' + type + 'Type').append($('<option>', { 
                value: types[i].id, 
                text: types[i].name 
            }));
        });
    });
};

// load planets into the home table and reset the planet-view
loadPlanets = () => {
    $('#planet-list').load('/planets');
    $('#planet-view').html('<div></div>');
    $('#deposit-view').html('<div></div>');
};

// loads a specific planet into view
loadPlanet = (id, callback) => {
    // if no callback is provided this is a first time load, so 
    callback = callback || function(){loadDeposits(id)};
    $('#planet-view').load('/planet/' + id, callback);
};

// saves a planet using the data submitted
savePlanet = () => {
    const data = formToObject('#planetForm');

    $.post('/planets', JSON.stringify(data), planet => {
        planetModal.hide();
        loadPlanets();
        loadPlanet(JSON.parse(planet).id);
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

// loads a list of deposits by planet
loadDeposits = (planetId) => {
    $('#deposit-view').load('/planet/' + planetId + '/deposits');
}

// loads a deposit into view
loadDeposit = (planetId, x, y) => {
    $('#deposit-view').load('/planet/' + planetId + '/deposit/x/' + x + '/y/' + y);
};

// warning message for no deposits at a specific location
showNoDepositWarning = (x, y) => {
    const coord = '(' + x + ', ' + y + ')';
    $('#deposit-view').html('<div class="alert alert-warning">No deposit recorded at ' + coord + '. Double click the cell to add one!</div>')
};

// saves a deposit from the data submitted
saveDeposit = () => {
    const data = formToObject('#depositForm');
    const { planetId, x, y } = data;

    $.post('/planet/' + planetId + '/deposits', JSON.stringify(data), () => {
        depositModal.hide();
        loadPlanet(planetId, () => loadDeposit(planetId, x, y));
    });
}

// deletes a deposit and then reloads the current planet view
deleteDeposit = (planetId, x, y) => {
    $.ajax({
        url: '/planet/' + planetId + '/deposit/x/' + x + '/y/' + y,
        type: 'DELETE',
        success: () => {
            loadPlanet(planetId);
        }
    });
};

// when the planet modal is opened load the planet types, and load the data for the 
// current planet if editing
$('#planetModal').on('show.bs.modal', event => {
    const { planetId } = getEntityAttrs(event);

    if (planetId) {
        $.getJSON('/planet/' + planetId + '/json', planet => {
            $('#planetId').val(planet.id);
            $('#planetName').val(planet.name);
            $('#planetType').val(planet.type.id).change();
            $('#planetSize').val(planet.size);
        });
    }
});

// when the planet modal is closed reset the form
$('#planetModal').on('hide.bs.modal', () => resetForm('#planetForm'));

// loads required data into the deposit modal, then fetches existing data and populates if it exists
loadDepositModalData = event => {
    const { planetId, x, y } = getEntityAttrs(event);

    $('#depositPlanetId').val(planetId);
    $('#x').val(x);
    $('#y').val(y);

    $.getJSON('/planet/' + planetId + '/deposit/x/' + x + '/y/' + y + '/json', deposit => {
        $('#depositType').val(deposit.type.id).change();
        $('#depositSize').val(deposit.size);
    });
};

// when the deposit modal is opened load the key data and data for the current deposit if exists
$('#depositModal').on('show.bs.modal', event => loadDepositModalData(event));

// when the deposit modal is closed reset the form
$('#depositModal').on('hide.bs.modal', () => resetForm('#depositForm'));

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
        const { planetId } = getEntityAttrs(e);
        loadPlanet(planetId);
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

        const { planetId } = getEntityAttrs(e);
        deletePlanet(planetId);
    });

    // when a grid cell is double clicked show the deposit modal
    // delegated as grid cells loaded dynamically
    $(document).on('dblclick', '.grid-cell', e => {
        depositModal.show(e.currentTarget);
    });

    // when an empty planet cell is clicked show a warning
    // delegated as grid cells loaded dynamically
    $(document).on('click', '.grid-cell-no-deposit', e => {
        const { x, y } = getEntityAttrs(e);
        showNoDepositWarning(x, y);
    });

    // when a deposit cell is clicked load the deposit data
    // delegated as grid cells loaded dynamically
    $(document).on('click', '.grid-cell-deposit', e => {
        const { planetId, x, y } = getEntityAttrs(e);
        loadDeposit(planetId, x, y);
    });

    // save deposit when form is submitted
    $('#depositFormSubmit').click(() => {
        saveDeposit();
    });

    // when a deposit delete icon is clicked delete the deposit
    // delegated as delete button loaded dynamicaly
    $(document).on('click', '.deposit-delete', e => {
        const { planetId, x, y } = getEntityAttrs(e);
        deleteDeposit(planetId, x, y);
    });
});