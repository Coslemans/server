<?php
include_once "../Interfaces/IDatabase.php";

class DatabaseService implements IDatabase
{
    private $hostname = 'db';
    private $username = 'root';
    private $password = 'example';
    private $database = 'shareposts';
    private $connection;

    public function getConnection()
    {
        $this->connection = null;

        try
        {
            $this->connection = new PDO("mysql:host=".$this->hostname.";dbname=".$this->database,$this->username, $this->password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch (PDOException $e)
        {
            exit("Error: " . $e->getMessage());
        }

        return $this->connection;
    }
}