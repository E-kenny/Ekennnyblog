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
        <a href='index.php' class='btn'>All Blogs</a>

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
    $categories->title = $_POST['title'];
    $categories->AdminId = $_SESSION['id'];
    $categories->create();
    $stmt=$categories->readOne();
    $stmt->bindParam(1,$_SESSION['id']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $blog->Category=$row['id'];

    // create the blog
    if($blog->create()){
        echo "<h1>Blog was created!!!</h1>";
        echo $blog->uploadPhoto();
    }
 
    // if unable to create the product, tell the user
    else{
        echo "<h1>Unable to create product!!!</h1>";
    }
}
?>
 
<!-- HTML form for creating a product -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
 
    <table class='table'>
 
        <tr>
            <td>Name</td>
            <td><input type='text' name='name'/></td>
        </tr>

        <tr>
        <td>Title</td>
            <td><input type='text' name='Tittle'/></td>
        </tr>

        <tr>
            <td>Description</td>
            <td><textarea name="description" id="" cols="30" rows="10"></textarea></td>
        </tr>
        
        <tr>
        <td>Image</td>
            <td><input type='file' name='image'/></td>
        </tr>

        <tr>
            <td>Category</td>
                <td>
                        <select name='title'>
                            <option >select title in decimal</option>
                            <option value='1.0'>1.0</option>
                            <option value='2.0'>2.0</option>
                           
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
<?php
 
// footer
include_once "layout_footer.php";
?>