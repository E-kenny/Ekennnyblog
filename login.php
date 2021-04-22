<?php
$page_title= "Log In";
// Include config file
include_once "config/database.php";
include_once 'objects/categories.php';
include_once 'objects/users.php';
include_once "layout_header.php";



//Initialize the session
session_start();

//Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
    // Validate credentials
    $database = new Database();
         $db = $database->getConnection();    
         $users = new Users($db);
         $users->email=$email;
         $users->password=$password;
         $users->login();
           
         // Close statement
            unset($stmt);
      
    }
    
    // Close connection
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
    <title>Login</title>
</head>

<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >

    <div class='form-group ' >
        <label class="control-label col-sm-2">Email</label>
        <div class="col-sm-10">
            <input type='email' name='email' class='form-control'/>
        </div>
    </div>

    <div class='form-group '>
        <label class="control-label col-sm-2">Password</label>
        <div class="col-sm-10">
            <input type='password' name='password' class='form-control'/>
        </div>
        <span><?php echo $password_err; ?></span>
    </div>

    <div class="form-group">
        
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Create</button>
        </div>
    </div>
</form>

<h3 >Don't have an account? <a href='signup.php' > Signup </a></h3>
<h3 >Forget password? <a href='forget_password.html' > Forget Password </a></h3>

</body>


<?php
include_once 'layout_footer.php';
?>