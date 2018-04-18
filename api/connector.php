<?php
class Connector 
{
    var $servername = "127.0.0.1";
    var $username = "eragonwien";
    var $password = "1212";
    var $dbname = "idlephp";
    var $connection = null;

    public function getConnection()
    {
        $conn = null;
        try
        {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
        }
        catch(PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
        finally
        {
            $this->connection = $conn;
            return $this->connection;
        }
    }

    function terminate()
    {
        $this->connection = null;
    }
}
