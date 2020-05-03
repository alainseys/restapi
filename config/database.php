<?php

class Database{
    private $host = 'db';
    private $dbname = 'development';
    private $dbuser = 'devuser';
    private $dbpass = 'devpassword';
    private $conn;

    public function connect(){
        $this->conn = null;

        try{
            $this->conn = new PDO('mysql:host='.$this->host .';dbname='.$this->dbname,$this->dbuser,$this->dbpass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e){
            echo 'Connection error:'. $e->getMessage();
        }
        return $this->conn;
    }
}