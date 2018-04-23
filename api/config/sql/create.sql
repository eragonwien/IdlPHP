DROP TABLE IF EXISTS 
	heroes.hero_relation, 
    heroes.hero_ability, 
    heroes.hero_team, 
    heroes.team, 
    heroes.ability, 
    heroes.alias, 
    heroes.hero;

CREATE TABLE heroes.hero (
	id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(45) NOT NULL UNIQUE,
    firstname VARCHAR(45) NOT NULL ,
    lastname VARCHAR(45) NOT NULL ,
    gender BOOLEAN NOT NULL DEFAULT true,
    image VARCHAR(45) NOT NULL DEFAULT 'default',
    PRIMARY KEY (id)
);

CREATE TABLE heroes.hero_relation (
	hero_id_1 INT NOT NULL,
    hero_id_2 INT NOT NULL,
    is_friendly BOOLEAN DEFAULT false,
    PRIMARY KEY (hero_id_1, hero_id_2),
    CONSTRAINT FK_hero FOREIGN KEY (hero_id_1) REFERENCES hero(id),
    CONSTRAINT FK_team FOREIGN KEY (hero_id_2) REFERENCES hero(id)
);

CREATE TABLE heroes.alias (
	id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(45) NOT NULL UNIQUE,
    hero_id INT NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT FK_Hero_Alias FOREIGN KEY (hero_id) REFERENCES hero(id)
);

CREATE TABLE heroes.ability (
	id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(45) NOT NULL UNIQUE,
    description VARCHAR(45) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE heroes.hero_ability (
	hero_id INT NOT NULL,
    ability_id INT NOT NULL,
    PRIMARY KEY (hero_id, ability_id),
    CONSTRAINT FK_hero_hero_ability FOREIGN KEY (hero_id) REFERENCES hero(id),
    CONSTRAINT FK_ability_hero_ability FOREIGN KEY (ability_id) REFERENCES ability(id)
);

CREATE TABLE heroes.team (
	id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(45) NOT NULL UNIQUE,
    leader_id INT,
    PRIMARY KEY (id),
    CONSTRAINT FK_team_leader FOREIGN KEY (leader_id) REFERENCES hero(id)
);

CREATE TABLE heroes.hero_team (
	hero_id INT NOT NULL,
    team_id INT NOT NULL,
    PRIMARY KEY (hero_id, team_id),
    CONSTRAINT FK_hero_hero_team FOREIGN KEY (hero_id) REFERENCES hero(id),
    CONSTRAINT FK_team_hero_team FOREIGN KEY (team_id) REFERENCES team(id)
);