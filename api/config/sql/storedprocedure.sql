DROP PROCEDURE IF EXISTS heroes.load_team;
DELIMITER $$
	CREATE PROCEDURE heroes.load_team(IN num int(4))
	BEGIN
		DECLARE counter int(4) default 0;
        DECLARE current_count int(4) default (SELECT count(1) FROM heroes.team);
		DECLARE team_name varchar(50) default '';

		IF current_count > 0 THEN 
			SET counter = current_count;
        END IF;
		SET num = counter + num;
		WHILE counter < num DO
			SET team_name = concat('Team #',counter);
			SET counter = counter + 1;
	 
			INSERT INTO team (name) Values(team_name);
		END WHILE;
	END
$$
DELIMITER ;



DROP PROCEDURE IF EXISTS heroes.load_heroes;
DELIMITER $$

CREATE PROCEDURE heroes.load_heroes(IN num int(4))
	BEGIN
		DECLARE counter int(4) default 0;
		DECLARE current_count int(4) default (SELECT count(1) FROM heroes.hero);
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