<?php
class Relation 
{
    private $heroId1;
    private $heroId2;
    private $isFriendly;
    private $connection;
    
    public function __construct( $connection) {
        $this->connection = $connection;
    }

    /**
     * Get the value of heroId1
     */ 
    public function getHeroId1()
    {
        return $this->heroId1;
    }

    /**
     * Set the value of heroId1
     *
     * @return  self
     */ 
    public function setHeroId1($heroId1)
    {
        $this->heroId1 = $heroId1;

        return $this;
    }

    /**
     * Get the value of heroId2
     */ 
    public function getHeroId2()
    {
        return $this->heroId2;
    }

    /**
     * Set the value of heroId2
     *
     * @return  self
     */ 
    public function setHeroId2($heroId2)
    {
        $this->heroId2 = $heroId2;

        return $this;
    }

    /**
     * Get the value of isFriendly
     */ 
    public function getIsFriendly()
    {
        return $this->isFriendly;
    }

    /**
     * Set the value of isFriendly
     *
     * @return  self
     */ 
    public function setIsFriendly($isFriendly)
    {
        $this->isFriendly = $isFriendly;

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
            $query = "SELECT * FROM hero_relation";
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

    public function getById($heroId1, $heroId2) {
        $result = null;
        try {
            $query = "SELECT * FROM hero_relation WHERE hero_id_1=:heroId1 AND hero_id_2=:heroId2";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':heroId1', $heroId1);
            $statement->bindParam(':heroId2', $heroId2);
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
            $query = "SELECT * FROM hero_relation r WHERE r.hero_id_1=:hero_id OR r.hero_id_2=:hero_id";
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
            $query = "INSERT INTO hero_relation(hero_id_1, hero_id_2, is_friendly) VALUES (:heroId1, :heroId2, :isFriendly) ON DUPLICATE KEY UPDATE hero_id_1 = hero_id_1";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':heroId1', $this->heroId1);
            $statement->bindParam(':heroId2', $this->heroId2);
            $statement->bindParam(':isFriendly', $this->isFriendly);
            $success = $statement->execute();

            // catch execution error here
            $result['success'] = ($success) ? true : false;
            if (!$success) {
                $errorInfo = $statement->errorInfo();
                $result['message'] = (isset($errorInfo[2])) ? $errorInfo[2] : null;
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
            $query = "UPDATE hero_relation SET is_friendly=:isFriendly WHERE hero_id_1=:hero_id_1 AND hero_id_2=:hero_id_2";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $this->id);
            $statement->bindParam(':isFriendly', $this->isFriendly);
            $statement->bindParam(':hero_id_1', $this->getHeroId1);
            $statement->bindParam(':hero_id_2', $this->getHeroId2);
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

    public function delete() {
        $result = null;
        try {
            $query = "DELETE FROM hero_relation WHERE hero_id_1=:heroId1 OR hero_id_2=:heroId2";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':heroId1', $this->heroId1);
            $statement->bindParam(':heroId2', $this->heroId2);
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
