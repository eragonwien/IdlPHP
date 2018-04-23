<?php
class Alias 
{
    private $id;
    private $name;
    private $heroId;
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    /**
     * Get the value of id
     */ 
    public function getId() {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName() {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of heroId
     */ 
    public function getHeroId() {
        return $this->heroId;
    }

    /**
     * Set the value of heroId
     *
     * @return  self
     */ 
    public function setHeroId($heroId) {
        $this->heroId = $heroId;

        return $this;
    }

    /**
     * Get the value of connection
     */ 
    public function getConnection() {
        return $this->connection;
    }

    /**
     * Set the value of connection
     *
     * @return  self
     */ 
    public function setConnection($connection) {
        $this->connection = $connection;

        return $this;
    }

    public function get() {
        $result = null;
        try {
            $query = "SELECT * FROM alias";
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
            $query = "SELECT * FROM alias WHERE id=:id";
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
            $query = "SELECT * FROM alias WHERE hero_id=:hero_id";
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
            $query = "INSERT INTO alias(name, hero_id) VALUES (:name, :hero_id)";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':hero_id', $this->heroId);
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
            $query = "UPDATE alias SET hero_id=:hero_id, name=:name WHERE id=:id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $this->id);
            $statement->bindParam(':hero_id', $this->heroId);
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
            $query = "DELETE FROM alias WHERE id=:id";
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
