<?php
class Database {
    private $host = "127.0.0.1";
    private $dbName = "heroes";
    private $username = "eragonwien";
    private $password = "1212";
    private $connection;
    
    public function getConnection()
    {
        $this->connection = null;

        try {
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbName, $this->username, $this->password);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        } finally {
            return $this->connection;
        }
    }
}