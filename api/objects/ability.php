<?php
class Ability 
{
    private $id;
    private $name;
    private $description;
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
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

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
            $query = 'SELECT * FROM ability';
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
            $query = 'SELECT * FROM ability WHERE id=:id';
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
            $query = 'SELECT a.id, a.name, a.description FROM ability a INNER JOIN hero_ability ha WHERE ha.hero_id=:hero_id';
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
            $query = 'INSERT INTO ability(name, description) VALUES (:name, :description)';
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':description', $this->description);
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
            $query = 'UPDATE ability SET name=:name, description=:description WHERE id=:id';
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $this->id);
            $statement->bindParam(':description', $this->description);
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
            $query = 'DELETE FROM ability WHERE id=:id';
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
