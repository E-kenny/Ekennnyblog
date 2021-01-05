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
 

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
 
    <table class='table'>

    <tr>
            <td>Name</td>
            <td><input type='text' name='name'/></td>
            <span ><?php echo $name_err; ?></span>
        </tr>
 
        <tr>
            <td>Email</td>
            <td><input type='email' name='email'/></td>
        </tr>

        <tr>
            <td>Password</td>
            <td><input type='password' name='password'/></td>
            <span><?php echo $password_err; ?></span>
        </tr>

        <tr>
            <td>Confirm Password</td>
            <td><input type='password' name='confirm_password'/></td>
            <span><?php echo $confirm_password_err; ?></span>
        </tr>

        <tr>
            <td>Admin</td>
                <td>
                        <select name='isAdmin'>
                            <option >Are you an Admin</option>
                            <option value='1'>Yes</option>
                            <option value='0'>No</option>
                           
                        </select>
                    
                </td>
        </tr>

       

        <tr>
            <td></td>
            <td>
                <button type="submit">Create</button>
            </td>
        </tr>
 
    </table>
</form>
<h3 class="su-li">Already have an account? <a href='login.php' > Login </a></h3>
<h3 class="su-li">Forget password? <a href='forget_password.html' > Forget Password </a></h3>

<?php
include_once 'layout_footer.php';
?>