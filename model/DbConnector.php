<?php

class DbConnector{

    private $hostname="localhost:3308";
    private $dbname="exchanze";
    private $dbuser="root";
    private $dbpw="";

    public function getConnection(){
        
        try {
            $dsn="mysql:host=".$this->hostname.";dbname=".$this->dbname;
            $con=new PDO($dsn,$this->dbuser,$this->dbpw);
            return $con;
        } catch (\Throwable $th) {
            die('Connection failed.'.$th->getMessage());
        }
    }
}



?>