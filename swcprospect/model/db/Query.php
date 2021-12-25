<?php

namespace swcprospect\model\db;

abstract class Query {
    
    const GET_PLANETS = 'SELECT p.id, p.name, p.size, pt.id AS type_id, pt.name AS type_name
                         FROM planets AS p
                         JOIN planet_types AS pt ON p.type = pt.id';

    const GET_PLANET = 'SELECT p.id, p.name, p.size, pt.id AS type_id, pt.name AS type_name
                        FROM planets AS p 
                        JOIN planet_types AS pt ON p.type = pt.id 
                        WHERE p.id = :id';

    const GET_PLANET_TYPES = 'SELECT id, name
                              FROM planet_types';

    const SAVE_PLANET = 'INSERT INTO planets (name, type, size) VALUES (:name, :type, :size)';

    const UPDATE_PLANET = 'REPLACE INTO planets (id, name, type, size) VALUES (:id, :name, :type, :size)';

    const DELETE_PLANET = 'DELETE FROM planets
                           WHERE id = :id';

    const GET_TILE = 'SELECT t.planet, t.x, t.y, tt.id AS type_id, tt.name AS type_name
                      FROM tiles AS t
                      JOIN tile_types AS tt ON t.type = tt.id
                      WHERE d.planet = :planetId AND d.x = :x AND d.y = :y';

    const GET_TILES_BY_PLANET = 'SELECT t.planet, t.x, t.y, tt.id AS type_id, tt.name AS type_name
                                 FROM tiles AS t
                                 JOIN tile_types AS tt ON t.type = tt.id
                                 WHERE t.planet = :planetId';

    const GET_TILE_TYPES = 'SELECT id, name
                            FROM tile_types';

    const SAVE_TILE = 'REPLACE INTO deposits (planet, x, y, type) VALUES (:planetId, :x, :y, :type)';

    const DELETE_TILES_BY_PLANET = 'DELETE FROM tiles
                                    WHERE planet = :planetId';

    const GET_DEPOSIT = 'SELECT d.planet, d.x, d.y, d.size, dt.id AS type_id, dt.name AS type_name
                         FROM deposits AS d
                         JOIN deposit_types AS dt ON d.type = dt.id 
                         WHERE d.planet = :planetId AND d.x = :x AND d.y = :y';

    const GET_DEPOSITS_BY_PLANET = 'SELECT d.planet, d.x, d.y, d.size, dt.id AS type_id, dt.name AS type_name
                                    FROM deposits AS d
                                    JOIN deposit_types AS dt ON d.type = dt.id
                                    WHERE d.planet = :planetId';

    const GET_DEPOSIT_TYPES = 'SELECT id, name
                               FROM deposit_types';

    const SAVE_DEPOSIT = 'REPLACE INTO deposits (planet, x, y, type, size) VALUES (:planetId, :x, :y, :type, :size)';

    const DELETE_DEPOSIT = 'DELETE FROM deposits
                            WHERE planet = :planetId AND x = :x AND y = :y';

    const DELETE_DEPOSITS_BY_PLANET = 'DELETE FROM deposits
                                       WHERE planet = :planetId';
}
?>