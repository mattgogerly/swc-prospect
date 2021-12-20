CREATE TABLE IF NOT EXISTS planets (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    type int NOT NULL,
    size int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (type) REFERENCES planet_types(id)
);

CREATE TABLE IF NOT EXISTS planet_types (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tiles {
    id int NOT NULL AUTO_INCREMENT,
    planet int NOT NULL,
    type int NOT NULL,
    x int NOT NULL,
    y int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (type) REFERENCES tile_types(id)
}

CREATE TABLE IF NOT EXISTS tile_types {
    id int NOT NULL AUTO_INCREMENT,
    name varchar(50) NOT_NULL,
    PRIMARY KEY (id)
}

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

CREATE TABLE IF NOT EXISTS deposit_types (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    PRIMARY KEY (id)
);