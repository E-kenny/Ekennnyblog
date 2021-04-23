<?php
$page_title= "Sign Up";
// Include config file
include_once "config/database.php";
include_once 'objects/categories.php';
include_once 'objects/users.php';
include_once "layout_header.php";

 
$database = new Database();
$db = $database->getConnection();

session_start();




// Define variables and initialize with empty values
$name=$password = $confirm_password =$email="";
$name_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter a name.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM user WHERE email = :email";
        
        if($stmt = $db->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $name_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong, Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($password_err) && empty($confirm_password_err)){
        
        
        $user = new Users($db);
        $user->names= $_POST['name'];
        $user->email= $email; 
        $user->password= $_POST['password'];
        $user->isAdmin= $_POST['isAdmin'];
        $user->signUp();
    }
    
     //Close connection
    unset($db);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Signup</title>
</head>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <div class='form-group'>
        <label class="control-label col-sm-2">Name</label>
        <div class="col-sm-10">
            <input type='text' name='name' class='form-control'/>
        </div>
        <span ><?php echo $name_err; ?></span>
    </div>
       
    
    <div class='form-group ' >
        <label class="control-label col-sm-2">Email</label>
        <div class="col-sm-10">
            <input type='email' name='email' class='form-control'/>
        </div>
    </div>

    <div class='form-group '>
        <label class="control-label col-sm-2">Admin</label>
        <div class="col-sm-10">
            <select name='isAdmin' class='form-control'>
                <option >Are you an Admin</option>
                <option value='1'>Yes</option>
                <option value='0'>No</option>
            </select>
        </div>

    <div class='form-group '>
        <label class="control-label col-sm-2">Password</label>
        <div class="col-sm-10">
            <input type='password' name='password' class='form-control'/>
        </div>
        <span><?php echo $password_err; ?></span>
    </div>

    
        
    </div>
    
    <div class='form-group '>
        <label class="control-label col-sm-2">Confirm Password</label>
        <div class="col-sm-10">
            <input type='password' name='confirm_password' class='form-control'/>
        </div>
        <span><?php echo $confirm_password_err; ?></span>
    </div>
    

   
    

    <div class="form-group">
        
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Signup</button>
        </div>
    </div>

</form>
<h3 >Already have an account? <a href='login.php' > Login </a></h3>
<h3 >Forget password? <a href='forget_password.html' > Forget Password </a></h3>

<?php
include_once 'layout_footer.php';
echo "</body>
</html>";

?>