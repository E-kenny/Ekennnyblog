<?php 
class Categories {
        // database connection and table name
        private $conn;
        private $table_name = "categories";

         // object properties
        public $id;
        public $title;
        public $AdminId;
        public $CreationDate;
        public $UpdationDate;


        public function __construct($db){
            $this->conn = $db;
        }  
        
        function create(){
 
            //write query
            $query = "INSERT INTO
                        " . $this->table_name . "
                    SET
                        title=:title,AdminId=:AdminId, CreationDate=:CreationDate, UpdationDate=:UpdationDate ";
     
            $stmt = $this->conn->prepare($query);
     
            // posted values
            $this->title=htmlspecialchars(strip_tags($this->title));
            $this->AdminId=htmlspecialchars(strip_tags($this->AdminId));
            $this->CreationDate=htmlspecialchars(strip_tags($this->CreationDate));
            $this->UpdationDate=htmlspecialchars(strip_tags($this->UpdationDate));
    
    
    
    
            $this->timestamp = date('Y-m-d H:i:s');
     
            // bind values 
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":AdminId", $this->AdminId);
            $stmt->bindParam(":CreationDate", $this->timestamp);
            $stmt->bindParam(":UpdationDate", $this->timestamp);
    
     
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
     
        }

        function read(){
            //select all data
            $query = "SELECT
                        id, title, AdminId
                    FROM
                        " . $this->table_name . "
                    ORDER BY
                        title";  
     
            $stmt = $this->conn->prepare( $query );
            $stmt->execute();
     
            return $stmt;
        }
    


        function readOne(){
  
            $query = "SELECT
                        id
                    FROM
                        " . $this->table_name . "
                    WHERE
                        AdminId = ?
                    LIMIT
                        0,1";
          
            $stmt = $this->conn->prepare( $query );
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
          
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
          
            $this->Tittle = $row['Tittle'];
            $this->description = $row['description'];
            $this->image = $row['image'];
            $this->UserId = $row['UserId'];
            $this->Category = $row['Category'];
            $this->CreationDate = $row['CreationDate'];
            $this->UpdationDate = $row['UpdationDate'];

            return $stmt;
    
        }
    
}