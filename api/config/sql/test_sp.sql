call load_heroes(100);
call load_team(100);
call load_ability(100);
call load_alias(100);
call load_hero_ability(100);
call load_hero_team(100);
call load_hero_relation(100);
select count(*) from hero;
select count(*) from ability;
select count(*) from alias;
select count(*) from team;
select * from hero;
select * from ability;
select * from alias;
select * from team;
select * from hero_ability;
select * from hero_team;
select * from hero_relation;
select count(ability_id) from hero_ability group by hero_id having count(ability_id) > 1;
select * from hero_ability group by hero_id, ability_id having count(*) > 1;
select * from hero_team group by hero_id, team_id having count(*) > 1;
select * from hero_relation group by hero_id_1, hero_id_2 having count(*) > 1;

