<?php
class Database {
    //Variables
    private $hostname;
    private $dbname;
    private $username;
    private $password;
    private $conn;

    public function connect(){
        //variable initialization
        $this->hostname = 'localhost';
        $this->dbname = 'guardtro_imonitor_db';
        $this->username = 'guardtro_imonutor_usr';
        $this->password = 'g#Y9eXACmQI*';

        $this->conn = new mysqli($this->hostname,$this->username,$this->password,$this->dbname);
        if ($this->conn->connect_errno) {
            print_r($this->conn->connect_errno);
            exit;
        } else {
            return $this->conn;
        }
    }
}
?>