<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// get ID of the blog to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once 'config/database.php';
include_once 'objects/blogs.php';
include_once 'objects/users.php';
include_once 'objects/categories.php';

  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$blog = new Blogs($db);
$user = new Users($db);
$categories = new Categories($db);
  
// ID property of blog to be edited
$blog->id = $id;
$blog->UserId=$user->id;

  
// read the details of blog to be edited
$blog->readOne();
$user->readOne();



//page header
$page_title="Update Record";
include_once 'layout_header.php';


echo "<div class='nav'>
          <a href='index.php' class='btn'>All Blogs</a>
     </div>";

     echo "<hr/>";

// if the form was submitted
if($_POST){
    $image=!empty($_FILES["image"]["name"])
? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"]) : "";
$blog->image = $image;
    // set  property values
    $user->name = $_POST['name'];
    $blog->Tittle = $_POST['title'];
    $blog->description = $_POST['description'];


    // update the blog
    if($blog->update()){
        echo "<div>";
            echo "<h1>Blog was updated!!!</h1>";
        echo "</div>";
    }
  
    // if unable to update the product, tell the user
    else{
        echo "<h1>";
            echo "Unable to update product.";
        echo "</h1>";
    }
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
<!-- 'update blog' form will be here -->

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post" enctype="multipart/form-data">
 
    <div class="form-group">
        <label class="control-label col-sm-2">Name</label>
        <div class="col-sm-10">
            <input type='text' name='name' class="form-control"/>
        </div>
    </div>

    <div class="form-group">
    <label class="control-label col-sm-2">Title</label>
        <div class="col-sm-10">
            <input type='text' name='Tittle' class="form-control"/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">Description</label>
        <div class="col-sm-10">
            <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
        </div>
    </div>

    <div class="form-group">
        <label  class="control-label col-sm-2">Category</label>
            <div class="col-sm-10">
                    <select name='title' class="form-control">
                        <option >select title in decimal</option>
                        <option value='1.0'>1.0</option>
                        <option value='2.0'>2.0</option>
                        
                    </select>
                
            </div>
    </div>
    
    <div class="form-group">
    <label class="control-label col-sm-2">Image</label>
        <div class="col-sm-10">
            <input type='file' name='image' class="form-control"/>
        </div>
    </div>

    


    <div class="form-group">
        
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Update</button>
        </div>
    </div>

    </form>
 </body>
</form>
<?php
include_once 'layout_footer.php';?>
<!-- post code will be here -->
