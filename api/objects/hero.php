<?php
class Hero {
    private $connection;
    private $table = "Hero";

    private $id;
    private $username;
    private $firstname;
    private $lastname;
    private $teamId;
    private $teamName;
    private $created;

    public function __construct($connection) {
        $this->connection = $connection;
    }
    
    public function get()
    {
        $query = "
            SELECT 
                h.id as id, h.username as username, h.firstname as firstname, h.lastname as lastname,
                t.id as teamId, t.name as teamName, t.isVillain as villain, t.description as description
            FROM 
                hero h INNER JOIN team t ON h.teamId = t.id;";
        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }
}