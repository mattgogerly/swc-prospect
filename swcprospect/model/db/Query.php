<?php

namespace swcprospect\model\db;

abstract class Query {
    
    const PLANETS            = 'SELECT p.id, p.name, p.size, pt.id AS type_id, pt.name AS type_name
                                FROM planets AS p
                                JOIN planet_types AS pt ON p.type = pt.id';

    const PLANET_BY_ID       = 'SELECT p.id, p.name, p.size, pt.id AS type_id, pt.name AS type_name
                                FROM planets AS p 
                                JOIN planet_types AS pt ON p.type = pt.id 
                                WHERE p.id = :id';

    const PLANET_TYPES       = 'SELECT id, name
                                FROM planet_types';

    const SAVE_PLANET        = 'INSERT INTO planets 
                                  (name, type, size) 
                                VALUES 
                                  (:name, :type, :size)';

    const UPDATE_PLANET      = 'UPDATE planets 
                                SET name = :name, type = :type, size = :size
                                WHERE id = :id';

    const DELETE_PLANET      = 'DELETE FROM planets
                                WHERE id = :id';

    const TILE_BY_COORD      = 'SELECT t.planet, t.x, t.y, tt.id AS type_id, tt.name AS type_name
                                FROM tiles AS t
                                JOIN tile_types AS tt ON t.type = tt.id
                                WHERE d.planet = :planetId AND d.x = :x AND d.y = :y';

    const TILES_BY_PLANET    = 'SELECT t.planet, t.x, t.y, tt.id AS type_id, tt.name AS type_name
                                FROM tiles AS t
                                JOIN tile_types AS tt ON t.type = tt.id
                                WHERE t.planet = :planetId';

    const TILE_TYPES         = 'SELECT id, name
                                FROM tile_types';

    const SAVE_TILE          = 'INSERT INTO tiles
                                  (planet, x, y, type)
                                VALUES
                                  (:planetId, :x, :y, :type)
                                ON DUPLICATE KEY UPDATE
                                  type = VALUES(type)';

    const DELETE_TILES       = 'DELETE FROM tiles
                                WHERE planet = :planetId';

    const DEPOSIT_BY_COORD   = 'SELECT d.planet, d.x, d.y, d.size, dt.id AS type_id, dt.name AS type_name
                                FROM deposits AS d
                                JOIN deposit_types AS dt ON d.type = dt.id 
                                WHERE d.planet = :planetId AND d.x = :x AND d.y = :y';

    const DEPOSITS_BY_PLANET = 'SELECT d.planet, d.x, d.y, d.size, dt.id AS type_id, dt.name AS type_name
                                FROM deposits AS d
                                JOIN deposit_types AS dt ON d.type = dt.id
                                WHERE d.planet = :planetId';

    const DEPOSIT_TYPES      = 'SELECT id, name
                                FROM deposit_types';

    const SAVE_DEPOSIT       = 'INSERT INTO deposits
                                  (planet, x, y, type, size)
                                VALUES
                                  (:planetId, :x, :y, :type, :size)
                                ON DUPLICATE KEY UPDATE
                                  type = VALUES(type), size = VALUES(size)';

    const DELETE_DEPOSIT     = 'DELETE FROM deposits
                                WHERE planet = :planetId AND x = :x AND y = :y';

    const DELETE_DEPOSITS    = 'DELETE FROM deposits
                                WHERE planet = :planetId';
}
