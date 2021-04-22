<?php
class Database{
  
    // specify your own database credentials
    // private $host = "remotemysql.com";
    // private $db_name = "ce5FGjzO2j";
    // private $username = "ce5FGjzO2j";
    // private $password = "hf86r1xnt2";
    // public $conn;

    private $host = "localhost";
    private $db_name = "ekennyblog";
    private $username = "root";
    private $password = "";
    public $conn;
  
    // get the database connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
  
        return $this->conn;
    }
}
?>