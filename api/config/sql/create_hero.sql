DROP TABLE IF EXISTS heroes.hero, heroes.team;

CREATE TABLE heroes.team (
	id int(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(45) NOT NULL UNIQUE,
    is_villain BOOLEAN NOT NULL,
    description VARCHAR(45) NOT NULL,
    lastname VARCHAR(45) NOT NULL,
    created DATETIME NOT NULL,
    updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE heroes.hero (
	id int(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(45) NOT NULL UNIQUE,
    firstname VARCHAR(45) NOT NULL,
    lastname VARCHAR(45) NOT NULL,
    team_id int(11) NOT NULL,
    created DATETIME NOT NULL,
    updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT FK_Hero_Team FOREIGN KEY (team_id) REFERENCES heroes.team(id)
);

