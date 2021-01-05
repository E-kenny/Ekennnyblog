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
 

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
 
    <table class='table'>
 
        <tr>
            <td>Email</td>
            <td><input type='email' name='email'/></td>
            <span><?php echo $email_err; ?></span>

        </tr>

        <tr>
            <td>Password</td>
            <td><input type='password' name='password'/></td>
            <span ><?php echo $password_err; ?></span>
        </tr>
 
        <tr>
            <td></td>
            <td>
                <button type="submit">login</button>
            </td>
        </tr>
 
    </table>
</form>
<h3 class="su-li">Don't have an account? <a href='signup.php' > Signup </a></h3>
<h3 class="su-li">Forget password? <a href='forget_password.html' > Forget Password </a></h3>

<?php
include_once 'layout_footer.php';
?>