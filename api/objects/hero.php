<?php
class Hero {
    private $connection;

    private $id;
    private $username;
    private $firstname;
    private $lastname;
    private $gender;

    public function __construct($connection) {
        $this->connection = $connection;
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
     * get all heroes
     * @return array all heroes
     */
    public function get(){
        $result = null;

        try {
            $query = 'SELECT * FROM heroes_full';
            $statement = $this->connection->prepare($query);
            $success = $statement->execute();

            // catch execution error here
            if (!$success) {
                $errorInfo = $statement->errorInfo();
                $result['message'] = (isset($errorInfo[2])) ? $errorInfo[2] : null;
            } else {
                $result = $statement;
            }
        } catch (PDOException $e) {
            $result['message'] = $e->getMessage();            
        } finally {
            return $result;
        }
    }

    /**
     * get hero by id
     * @param int id of hero
     * @return Hero one hero returned
     */
    public function getById(int $id){
        $result = null;

        try {
            $query = 'SELECT * FROM heroes_full WHERE id = :id';
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
        } catch (PDOException $e) {
            $result['message'] = $e->getMessage();            
        } finally {
            return $result;
        }
    }

    /**
     * create a new hero
     * on success, returns last insert id
     * on failure, returns error message
     * @return array result of the operation
     */
    public function create(){
        $result = array();
        try {
            $query = 'INSERT INTO hero (username, firstname, lastname, gender) VALUES (:username, :firstname, :lastname, :gender)';

            $genderInt = ($this->gender) ? 1 : 0;

            $statement = $this->connection->prepare($query);
            $statement->bindParam(':username', $this->username);
            $statement->bindParam(':firstname', $this->firstname);
            $statement->bindParam(':lastname', $this->lastname);
            $statement->bindParam(':gender', $genderInt);

            $success = $statement->execute();
            $result['success'] = ($success) ? true : false;
            // catch execution error here
            if (!$success) {
                $errorInfo = $statement->errorInfo();
                $result['message'] = (isset($errorInfo[2])) ? $errorInfo[2] : null;
            } else {
                $result['id'] = $this->connection->lastInsertId();
            }
        } catch (PDOException $e) {
            $result['message'] = $e->getMessage();
        } finally {
            return $result;
        }
    }

    /**
     * update a hero
     * on success, returns affected rows
     * on failure, returns error message
     * @return array result of the operation
     */
    public function update(){
        $result = array();
        try {
            $query = 'UPDATE hero SET username=:username, firstname=:firstname, lastname=:lastname, gender=:gender WHERE id=:id';

            $genderInt = ($this->gender) ? 1 : 0;

            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $this->id);
            $statement->bindParam(':username', $this->username);
            $statement->bindParam(':firstname', $this->firstname);
            $statement->bindParam(':lastname', $this->lastname);
            $statement->bindParam(':gender', $genderInt);

            $success = $statement->execute();
            $result['success'] = ($success) ? true : false;
            // catch execution error here
            if (!$success) {
                $errorInfo = $statement->errorInfo();
                $result['message'] = (isset($errorInfo[2])) ? $errorInfo[2] : null;
            } else {
                $result['id'] = $this->connection->affectedRows();
            }
        } catch (PDOException $e) {
            $result['message'] = $e->getMessage();
        } finally {
            return $result;
        }
    }

    /**
     * delete a hero
     * on success, returns affected rows
     * on failure, returns error message
     * @return array result of the operation
     */
    public function delete(int $id)
    {
        $result = array();

        try {
            $query = 'SELECT * FROM hero WHERE id = :id';
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $id);
            $success = $statement->execute();

            // catch execution error here
            if (!$success) {
                $errorInfo = $statement->errorInfo();
                $result['message'] = (isset($errorInfo[2])) ? $errorInfo[2] : null;
            } else {
                $result['id'] = $this->connection->affectedRows();
            }
        } catch (PDOException $e) {
            $result['message'] = $e->getMessage();            
        } finally {
            return $result;
        }
    }
}