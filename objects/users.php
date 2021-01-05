<?php 

class Users {
        // database connection and table name
        private $conn;
        private $table_name = "user";

         // object properties
        public $id;
        public $names;
        public $email;
        public $password;
        public $isAdmin;
        public $CreationDate;
        public $UpdationDate;


        public function __construct($db){
            $this->conn = $db;
        }  
        

        function signUp(){
             // Prepare an insert statement
        $sql = "INSERT INTO  " . $this->table_name . " ( names, email, password, isAdmin, CreationDate, UpdationDate) VALUES (:name,:email, :password, :isAdmin, :CreationDate, :UpdationDate)";
       // $hashed_password= password_hash($this->password, PASSWORD_DEFAULT) ;

        if($stmt = $this->conn->prepare($sql)){

            $this->timestamp = date('Y-m-d H:i:s');
        
            // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":name", $this->names);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password",$this->password);
        $stmt->bindParam(":isAdmin", $this->isAdmin);              
        $stmt->bindParam(":CreationDate", $this->timestamp);
        $stmt->bindParam(":UpdationDate", $this->timestamp);            
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
               
                // Redirect to login page
            header("location: login.php");

            
            } else{
                echo "Something went wrong, Please try again later.";
            }
        }
    }
       
    function login(){
            
                // Prepare a select statement
                $sql = "SELECT id, names, email, password FROM " . $this->table_name . " WHERE email = :email";
                
                if($stmt = $this->conn->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                    
                    // Set parameters
                    $param_email = $this->email ;
                    
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Check if username exists, if yes then verify password
                        if($stmt->rowCount() == 1){
                            if($row = $stmt->fetch()){
                                $this->id = $row["id"];
                                $this->email = $row["email"];
                                $this->names = $row["names"];
                                $tablepassword = $row["password"];
                                if($this->password===$tablepassword){
                                    // Password is correct, so start a new session
                                    session_start();
                                    
                                    // Store data in session variables
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["id"] = $this->id;
                                    $_SESSION["email"] = $this->email;
                                    $_SESSION["name"] = $this->names;                            

                                   
                            
                                    // Redirect user to index page
                                    header("location: index.php");
                                } else{
                                    // Display an error message if password is not valid
                                     echo "The password you entered was not valid.";
                                }
                            }
                        } else{
                            // Display an error message if username doesn't exist
                        echo "No account found with that email.";
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        


                }

        }

        function create(){
         //write query
            $query = "INSERT INTO
                        " . $this->table_name . "
                    SET
                        names=:names, email=:email, password=:password, isAdmin=:isAdmin , CreationDate=:CreationDate, UpdationDate=:UpdationDate ";
     
            $stmt = $this->conn->prepare($query);
     
            // posted values
            $this->names=htmlspecialchars(strip_tags($this->names));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->password=htmlspecialchars(strip_tags($this->password));
            $this->isAdmin=htmlspecialchars(strip_tags($this->isAdmin));
            $this->CreationDate=htmlspecialchars(strip_tags($this->CreationDate));
            $this->UpdationDate=htmlspecialchars(strip_tags($this->UpdationDate));
    
    
    
    
            $this->timestamp = date('Y-m-d H:i:s');
     
            // bind values 
            // $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":names", $this->names);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":isAdmin", $this->isAdmin);
            $stmt->bindParam(":CreationDate", $this->timestamp);
            $stmt->bindParam(":UpdationDate", $this->timestamp);
    
     
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
     
        }

        function readOne(){
  
            $query = "SELECT
                        names, CreationDate, UpdationDate
                    FROM
                        " . $this->table_name . "
                    WHERE
                        id = ?
                    LIMIT
                        0,1";
          
            $stmt = $this->conn->prepare( $query );
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
           if ($row = $stmt->fetch(PDO::FETCH_ASSOC) ) {          
            $this->names = $row['names'];
            $this->CreationDate = $row['CreationDate'];
            $this->UpdationDate = $row['UpdationDate'];
    
           }else{
               echo $this->id;
               echo "can't read";
           }
          
           
        }
       
        function getId(){
              // Prepare a select statement
        $sql = "SELECT id FROM user WHERE email = :email";
        
        if($stmt = $db->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            
            // Set parameters
            $param_email = $this->email;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                return $this->id;
            }

        }
    }
       

    

       
    
}