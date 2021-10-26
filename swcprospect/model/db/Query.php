<?php

namespace swcprospect\model\db;

abstract class Query {
    const GET_PLANETS = 'SELECT * FROM planets';

    const GET_PLANET = 'SELECT * FROM planets WHERE id = :id';

    const GET_PLANET_TYPES = 'SELECT * FROM planet_types';

    const GET_DEPOSITS_BY_PLANET = 'SELECT * FROM deposits WHERE planet = :id';

    const GET_DEPOSIT_TYPES = 'SELECT * FROM deposit_types';
}
?>