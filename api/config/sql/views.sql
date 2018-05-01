CREATE OR REPLACE VIEW heroes_full AS
	SELECT 
		h.id as id, h.username as username, h.firstname as firstname, h.lastname as lastname, h.gender as gender
    FROM 
		hero h
	ORDER BY id, username ASC;
    
SELECT * FROM heroes_full;