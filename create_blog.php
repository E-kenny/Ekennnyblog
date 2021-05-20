<?php

// Initialize the session
session_start();
 
//Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


// include database and object files
include_once 'config/database.php';
include_once 'objects/blogs.php';
include_once 'objects/users.php';
include_once 'objects/categories.php';

 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// pass connection to objects
$blog = new Blogs($db);
$user = new Users($db);
$categories = new Categories($db);

// set page headers
$page_title = "Create Blog";
include_once "layout_header.php";
 
// contents will be here
echo "<div class='nav'>
        <a href='index.php' class='btn'><button>All Blogs</button></a>

    </div>";
 
?>
<hr/>



<!-- 'create blog' html form will be here -->

<?php 

// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
    $image=!empty($_FILES["image"]["name"])
? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"]) : "";
$blog->image = $image;
    
    // set blog property values
    $_SESSION['name'] = $_POST['name'];
    $user->name = $_SESSION['name'];
    $blog->Tittle = $_POST['Tittle'];
    $blog->description = $_POST['description'];
    $blog->UserId=$_SESSION['id'];
    $blog->Category=5;
    $categories = new Categories($db);
    $categories->title = $_POST['Tittle'];
    $categories->AdminId = $_SESSION['id'];
    $categories->create();
    $stmt=$categories->readOne();
    $stmt->bindParam(1,$_SESSION['id']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $blog->Category=$row['id'];

    // create the blog
    if($blog->create()){
        echo "<h3>Blog was created!!!</h3>";
        echo $blog->uploadPhoto();
    }
 
    // if unable to create the product, tell the user
    else{
        echo "<h3>Unable to create product!!!</h3>";
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
     <!-- HTML form for creating a product -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
  
    <div class="form-group">
        <label class="control-label col-sm-2">Name</label>
        <div class="col-sm-10">
            <input type='text' name='name' class="form-control" required/>
        </div>
    </div>

    <div class="form-group">
    <label class="control-label col-sm-2">Title</label>
        <div class="col-sm-10">
            <input type='text' name='Tittle' class="form-control" required/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">Description</label>
        <div class="col-sm-10">
            <textarea name="description" id="" cols="30" rows="10" class="form-control" required></textarea>
        </div>
    </div>
    
    <div class="form-group">
    <label class="control-label col-sm-2" required>Image</label>
        <div class="col-sm-10">
            <input type='file' name='image' class="form-control"/>
        </div>
    </div>

    
    <div class="form-group">
        
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Create</button>
        </div>
    </div>

    </form>
 </body>

<?php
 
// footer
include_once "layout_footer.php";
?>