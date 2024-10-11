<?php

class DbConnector{

    private $hostname="localhost";
    private $dbname="exchanze";
    private $dbuser="root";
    private $dbpw="";
    private $port = 3308;

    public function getConnection(){
        
        try {
            $dsn="mysql:host=".$this->hostname.";port=".$this->port.";dbname=".$this->dbname;
            $con=new PDO($dsn,$this->dbuser,$this->dbpw);
            return $con;
        } catch (\Throwable $th) {
            die('Connection failed.'.$th->getMessage());
        }
    }
}



?>