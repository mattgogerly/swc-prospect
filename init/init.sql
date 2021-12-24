CREATE DATABASE IF NOT EXISTS swcprospect;

USE swcprospect;

CREATE TABLE IF NOT EXISTS planet_types (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS planets (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    type int NOT NULL,
    size int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (type) REFERENCES planet_types(id)
);

CREATE TABLE IF NOT EXISTS tile_types (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(50) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tiles (
    planet int NOT NULL,
    x int NOT NULL,
    y int NOT NULL,
    type int NOT NULL,
    PRIMARY KEY (planet, x, y),
    FOREIGN KEY (planet) REFERENCES planets(id),
    FOREIGN KEY (type) REFERENCES tile_types(id)
);

CREATE TABLE IF NOT EXISTS deposit_types (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS deposits (
    id int NOT NULL AUTO_INCREMENT,
    planet int NOT NULL,
    x int NOT NULL,
    y int NOT NULL,
    type int NOT NULL,
    size int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (planet) REFERENCES planets(id),
    FOREIGN KEY (type) REFERENCES deposit_types(id)
);

REPLACE INTO planet_types
    (id, name)
VALUES
    (1, 'Hot No Atmos'), (2, 'Hot Toxic'), (3, 'Hot Breathable'), 
    (4, 'Temperate Breathable'), (5, 'Cold Breathable'), (6, 'Cold Toxic'), 
    (7, 'Cold No Atmos'), (8, 'Gas Giant'), (9, 'Moon'), 
    (10, 'Asteroid'), (11, 'Comet'), (12, 'Temperate Toxic');

REPLACE INTO tile_types 
    (id, name)
VALUES
    (1, 'Cave'), (2, 'Crater'), (3, 'Desert'), (4, 'Forest'), (5, 'Gas Giant'),
    (6, 'Glacier'), (7, 'Grassland'), (8, 'Jungle'), (9, 'Mountain'), (10, 'Ocean'),
    (11, 'River'), (12, 'Rock'), (13, 'Swamp'), (14, 'Volcanic');

REPLACE INTO deposit_types 
    (id, name)
VALUES
    (1, 'Quantum'), (2, 'Meleenium'), (3, 'Ardanium'), (4, 'Rudic'), (5, 'Ryll'),
    (6, 'Duracrete'), (7, 'Alazhi'), (8, 'Laboi'), (9, 'Adegan'), (10, 'Rockivory'),
    (11, 'Tibannagas'), (12, 'Nova'), (13, 'Varium'), (14, 'Varmigio'), (15, 'Lommite'),
    (16, 'Hibridium'), (17, 'Durelium'), (18, 'Lowickan'), (19, 'Vertex'), (20, 'Berubian'),
    (21, 'Bacta');