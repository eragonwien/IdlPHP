<?php
class Team  
{
    private $id;
    private $name;
    private $leaderId;
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of leaderId
     */ 
    public function getLeaderId()
    {
        return $this->leaderId;
    }

    /**
     * Set the value of leaderId
     *
     * @return  self
     */ 
    public function setLeaderId($leaderId)
    {
        $this->leaderId = $leaderId;

        return $this;
    }

    /**
     * Get the value of connection
     */ 
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Set the value of connection
     *
     * @return  self
     */ 
    public function setConnection($connection)
    {
        $this->connection = $connection;

        return $this;
    }

    
    public function get() {
        $result = null;
        try {
            $query = 'SELECT * FROM team';
            $statement = $this->connection->prepare($query);
            $success = $statement->execute();

            // catch execution error here
            $result['success'] = ($success) ? true : false;
            if (!$success) {
                $errorInfo = $statement->errorInfo();
                $result['message'] = (isset($errorInfo[2])) ? $errorInfo[2] : null;
            } else {
                $result = $statement;
            }
        }
        catch (PDOException $e) {
            $result['message'] = $e->getMessage();                        
        }
        finally {
            return $result;
        }
    }

    public function getById($id) {
        $result = null;
        try {
            $query = 'SELECT * FROM team WHERE id=:id';
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $id);
            $success = $statement->execute();

            // catch execution error here
            $result['success'] = ($success) ? true : false;
            if (!$success) {
                $errorInfo = $statement->errorInfo();
                $result['message'] = (isset($errorInfo[2])) ? $errorInfo[2] : null;
            } else {
                $result = $statement;
            }
        }
        catch (PDOException $e) {
            $result['message'] = $e->getMessage();                        
        }
        finally {
            return $result;
        }
    }

    public function getOfHero($heroId) {
        $result = null;
        try {
            $query = 'SELECT t.id, t.name, t.leader_id FROM team t INNER JOIN hero_team ht WHERE ht.hero_id=:hero_id';
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':hero_id', $heroId);
            $success = $statement->execute();

            // catch execution error here
            if (!$success) {
                $errorInfo = $statement->errorInfo();
                $result['message'] = (isset($errorInfo[2])) ? $errorInfo[2] : null;
            } else {
                $result = $statement;
            }
        }
        catch (PDOException $e) {
            $result['message'] = $e->getMessage();                        
        }
        finally {
            return $result;
        }
    }

    public function create() {
        $result = null;
        try {
            $query = 'INSERT INTO team(name, leader_id) VALUES (:name, :leader_id)';
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':leader_id', $this->leaderId);
            $statement->bindParam(':name', $this->name);
            $success = $statement->execute();

            // catch execution error here
            $result['success'] = ($success) ? true : false;
            if (!$success) {
                $errorInfo = $statement->errorInfo();
                $result['message'] = (isset($errorInfo[2])) ? $errorInfo[2] : null;
            } else {
                $result['id'] = $this->connection->lastInsertId();
            }
        }
        catch (PDOException $e) {
            $result['message'] = $e->getMessage();                        
        }
        finally {
            return $result;
        }
    }

    public function update() {
        $result = null;
        try {
            $query = 'UPDATE team SET name=:name, leader_id=:leader_id WHERE id=:id';
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $this->id);
            $statement->bindParam(':leader_id', $this->leaderId);
            $statement->bindParam(':name', $this->name);
            $success = $statement->execute();

            // catch execution error here
            $result['success'] = ($success) ? true : false;
            if (!$success) {
                $errorInfo = $statement->errorInfo();
                $result['message'] = (isset($errorInfo[2])) ? $errorInfo[2] : null;
            } else {
                $result = $statement;
            }
        }
        catch (PDOException $e) {
            $result['message'] = $e->getMessage();                        
        }
        finally {
            return $result;
        }
    }

    public function delete($id) {
        $result = null;
        try {
            $query = 'DELETE FROM team WHERE id=:id';
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $this->id);
            $success = $statement->execute();

            // catch execution error here
            $result['success'] = ($success) ? true : false;
            if (!$success) {
                $errorInfo = $statement->errorInfo();
                $result['message'] = (isset($errorInfo[2])) ? $errorInfo[2] : null;
            } else {
                $result = $statement;
            }
        }
        catch (PDOException $e) {
            $result['message'] = $e->getMessage();                        
        }
        finally {
            return $result;
        }
    }
}
