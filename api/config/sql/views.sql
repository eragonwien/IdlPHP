CREATE OR REPLACE VIEW heroes.heroes_full AS
	SELECT 
		h.id as id, h.username as username, h.firstname as firstname, h.lastname as lastname, h.gender as gender, h.image as image

        
    FROM 
		heroes.hero h
	ORDER BY id, username ASC;
    
SELECT * FROM heroes.heroes_full;