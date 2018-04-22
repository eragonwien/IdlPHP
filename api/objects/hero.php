<?php
class Hero {
    private $connection;

    private $id;
    private $username;
    private $firstname;
    private $lastname;
    private $gender;
    private $image;

    public function __construct($connection) {
        $this->connection = $connection;
    }
    
    public function get(){
        $result = null;

        try {
            $query = "SELECT * FROM heroes.heroes_full";
            $statement = $this->connection->prepare($query);
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

    public function getById(int $id){
        $result = null;

        try {
            $query = "SELECT * FROM heroes.heroes_full WHERE id = :id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $id);
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

    public function create(){
        $result = array();
        try {
            $query = "INSERT INTO heroes.hero (username, firstname, lastname, gender, image) VALUES (:username, :firstname, :lastname, :gender, :image)";

            $genderInt = ($this->gender) ? 1 : 0;

            $statement = $this->connection->prepare($query);
            $statement->bindParam(':username', $this->username);
            $statement->bindParam(':firstname', $this->firstname);
            $statement->bindParam(':lastname', $this->lastname);
            $statement->bindParam(':gender', $genderInt);
            $statement->bindParam(':image', $this->image);

            $success = $statement->execute();
            $result['success'] = ($success) ? true : false;
            // catch execution error here
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

    public function update(){
        $result = array();
        try {
            $query = "UPDATE heroes.hero SET username=:username, firstname=:firstname, lastname=:lastname, gender=:gender, image=:image WHERE id=:id";

            $genderInt = ($this->gender) ? 1 : 0;

            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $this->id);
            $statement->bindParam(':username', $this->username);
            $statement->bindParam(':firstname', $this->firstname);
            $statement->bindParam(':lastname', $this->lastname);
            $statement->bindParam(':gender', $genderInt);
            $statement->bindParam(':image', $this->image);

            $success = $statement->execute();
            $result['success'] = ($success) ? true : false;
            // catch execution error here
            if (!$success) {
                $errorInfo = $statement->errorInfo();
                $result['message'] = (isset($errorInfo[2])) ? $errorInfo[2] : null;
            } else {
                $result['id'] = $this->connection->affectedRows();
            }
        }
        catch (PDOException $e) {
            $result['message'] = $e->getMessage();
        } 
        finally {
            return $result;
        }
    }

    public function deleteById(int $id)
    {
        $result = null;

        try {
            $query = "SELECT * FROM heroes.hero WHERE id = :id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $id);
            $success = $statement->execute();

            // catch execution error here
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

    /**
     * Get the value of id
     */ 
    public function getId(){
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(int $id){
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername(){
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username){
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname(){
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname){
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname(){
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname){
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of gender
     */ 
    public function getGender(){
        return $this->gender;
    }

    /**
     * Set the value of gender
     *
     * @return  self
     */ 
    public function setGender($gender){
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get the value of image
     */ 
    public function getImage(){
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image){
        $this->image = $image;

        return $this;
    }
}