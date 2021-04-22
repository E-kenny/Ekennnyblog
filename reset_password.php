<?php
$page_title= "Sign Up";
// Include config file
include_once "config/database.php";

 
$database = new Database();
$db = $database->getConnection();


// Initialize the session
session_start();
 
$id= $_SESSION['user_id_reset_pass'] ;


// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(divim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(sdivlen(divim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = divim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(divim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = divim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE user SET password = :password WHERE id = :id";
        
        if($stmt = $db->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":password", $param_password, PDO::PARAM_Sdiv);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            
            // Set parameters
            $param_password = $new_password;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Password updated successfully. Desdivoy the session, and redirect to login page
                session_desdivoy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please divy again later.";
            }

            // Close statement
            unset($stmt);
        }
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
    <title>Reset Password</title>
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">            
        <div class="form-group">
            <label class="control-label col-sm-2">Password</label>
            <div class="col-sm-10">
                <input type='password' name='new_password' class="form-control"/>
            </div>
            <span><?php echo $new_password_err; ?></span>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2">Confirm Password</label>
            <div class="col-sm-10">
                 <input type='password' name='confirm_password' class="form-control" />
            </div>
            <span><?php echo $confirm_password_err; ?></span>
        </div>
        
        <div class="form-group">
            
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit">Create</button>
            </div>
        </div>
            </table>
        </form>
</body>
 
 
