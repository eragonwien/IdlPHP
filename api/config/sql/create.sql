DROP TABLE IF EXISTS 
	hero_relation, 
    hero_ability, 
    hero_team, 
    team, 
    ability, 
    alias, 
    hero,
    image;

CREATE TABLE hero (
	id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(45) NOT NULL UNIQUE,
    firstname VARCHAR(45) NOT NULL ,
    lastname VARCHAR(45) NOT NULL ,
    gender BOOLEAN NOT NULL DEFAULT true,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE hero_relation (
	hero_id_1 INT NOT NULL,
    hero_id_2 INT NOT NULL,
    is_friendly BOOLEAN DEFAULT false,
    PRIMARY KEY (hero_id_1, hero_id_2),
    CONSTRAINT FK_hero FOREIGN KEY (hero_id_1) REFERENCES hero(id),
    CONSTRAINT FK_team FOREIGN KEY (hero_id_2) REFERENCES hero(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE alias (
	id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(45) NOT NULL UNIQUE,
    hero_id INT NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT FK_Hero_Alias FOREIGN KEY (hero_id) REFERENCES hero(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE ability (
	id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(45) NOT NULL UNIQUE,
    description VARCHAR(45) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE hero_ability (
	hero_id INT NOT NULL,
    ability_id INT NOT NULL,
    PRIMARY KEY (hero_id, ability_id),
    CONSTRAINT FK_hero_hero_ability FOREIGN KEY (hero_id) REFERENCES hero(id),
    CONSTRAINT FK_ability_hero_ability FOREIGN KEY (ability_id) REFERENCES ability(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE team (
	id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(45) NOT NULL UNIQUE,
    leader_id INT,
    PRIMARY KEY (id),
    CONSTRAINT FK_team_leader FOREIGN KEY (leader_id) REFERENCES hero(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE hero_team (
	hero_id INT NOT NULL,
    team_id INT NOT NULL,
    PRIMARY KEY (hero_id, team_id),
    CONSTRAINT FK_hero_hero_team FOREIGN KEY (hero_id) REFERENCES hero(id),
    CONSTRAINT FK_team_hero_team FOREIGN KEY (team_id) REFERENCES team(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;