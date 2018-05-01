DROP PROCEDURE IF EXISTS load_team;
DELIMITER $$
	CREATE PROCEDURE load_team(IN num int(4))
	BEGIN
		DECLARE counter int(4) default 0;
        DECLARE current_count int(4) default (SELECT count(1) FROM team);
		DECLARE team_name varchar(50) default '';
		DECLARE leader_id int(4) default 0;

		IF current_count > 0 THEN 
			SET counter = current_count;
        END IF;
		SET num = counter + num;
		WHILE counter < num DO
			SET team_name = concat('Team #',counter);
            SET leader_id = (SELECT id FROM hero ORDER BY rand() LIMIT 1);
			SET counter = counter + 1;
	 
			INSERT INTO team (name, leader_id) Values(team_name, leader_id);
		END WHILE;
	END
$$
DELIMITER ;



DROP PROCEDURE IF EXISTS load_heroes;
DELIMITER $$

CREATE PROCEDURE load_heroes(IN num int(4))
	BEGIN
		DECLARE counter int(4) default 0;
		DECLARE current_count int(4) default (SELECT count(1) FROM hero);
		DECLARE username VARCHAR(45) default '';
		DECLARE firstname VARCHAR(45) default 'first';
		DECLARE lastname VARCHAR(45) default 'last';
		DECLARE gender BOOLEAN default true;

		IF current_count > 0 THEN
			SET counter = current_count;
		END IF;
		SET num = counter + num;
		WHILE counter < num DO
			SET username = concat('Hero#',counter);
			SET gender = ROUND(RAND());
			SET counter = counter + 1;
	 
			INSERT INTO hero (username, firstname, lastname, gender)
				Values(username, firstname, lastname, gender);
		END WHILE;
	END
$$
 
DELIMITER ;


DROP PROCEDURE IF EXISTS load_ability;
DELIMITER $$

CREATE PROCEDURE load_ability(IN num int(4))
	BEGIN
		DECLARE counter int(4) default 0;
		DECLARE current_count int(4) default (SELECT count(1) FROM hero);
		DECLARE name VARCHAR(45) default '';
        DECLARE description VARCHAR(45) default '';

		IF current_count > 0 THEN
			SET counter = current_count;
		END IF;
		SET num = counter + num;
		WHILE counter < num DO
			SET name = concat('Ability #',counter);
			SET description = concat('Description for Ability #',counter);
			SET counter = counter + 1;
	 
			INSERT INTO ability (name, description)
				Values(name, description);
		END WHILE;
	END
$$
 
DELIMITER ;

DROP PROCEDURE IF EXISTS load_alias;
DELIMITER $$

CREATE PROCEDURE load_alias(IN num int(4))
	BEGIN
		DECLARE counter int(4) default 0;
		DECLARE current_count int(4) default (SELECT count(1) FROM hero);
		DECLARE hero_id int(4) default 0;
		DECLARE name VARCHAR(45) default '';

		IF current_count > 0 THEN
			SET counter = current_count;
		END IF;
		SET num = counter + num;
		WHILE counter < num DO
			SET name = concat('Alias #',counter);
            SET hero_id = (SELECT id FROM hero ORDER BY rand() LIMIT 1);
			SET counter = counter + 1;
	 
			INSERT INTO alias (name, hero_id)
				Values(name, hero_id);
		END WHILE;
	END
$$
 
DELIMITER ;

DROP PROCEDURE IF EXISTS load_hero_ability;
DELIMITER $$

CREATE PROCEDURE load_hero_ability(IN num int(4))
	BEGIN
		DECLARE counter int(4) default 0;
		DECLARE hero_id int(4) default 0;
		DECLARE ability_id int(4) default 0;

		WHILE counter < num DO
            SET hero_id = (SELECT id FROM hero ORDER BY rand() LIMIT 1);
            SET ability_id = (SELECT id FROM ability ORDER BY rand() LIMIT 1);
			SET counter = counter + 1;
	 
			INSERT INTO hero_ability (hero_id, ability_id)
				Values(hero_id, ability_id);
		END WHILE;
	END
$$
 
DELIMITER ;


DROP PROCEDURE IF EXISTS load_hero_team;
DELIMITER $$

CREATE PROCEDURE load_hero_team(IN num int(4))
	BEGIN
		DECLARE counter int(4) default 0;
		DECLARE hero_id int(4) default 0;
		DECLARE team_id int(4) default 0;

		WHILE counter < num DO
            SET hero_id = (SELECT id FROM hero ORDER BY rand() LIMIT 1);
            SET team_id = (SELECT id FROM team ORDER BY rand() LIMIT 1);
			SET counter = counter + 1;
	 
			INSERT INTO hero_team (hero_id, team_id)
				Values(hero_id, team_id);
		END WHILE;
	END
$$
 
DELIMITER ;

DROP PROCEDURE IF EXISTS load_hero_relation;
DELIMITER $$

CREATE PROCEDURE load_hero_relation(IN num int(4))
	BEGIN
		DECLARE counter int(4) default 0;
		DECLARE hero_id_1 int(4) default 0;
		DECLARE hero_id_2 int(4) default 0;
		DECLARE is_friendly boolean default false;

		WHILE counter < num DO
            SET hero_id_1 = (SELECT id FROM hero ORDER BY rand() LIMIT 1);
            SET hero_id_2 = (SELECT id FROM hero ORDER BY rand() LIMIT 1);
            SET is_friendly = (floor(rand()*10) % 2);
			SET counter = counter + 1;
	 
			INSERT INTO hero_relation (hero_id_1, hero_id_2, is_friendly)
				Values(hero_id_1, hero_id_2, is_friendly);
		END WHILE;
	END
$$
 
DELIMITER ;