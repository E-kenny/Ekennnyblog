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
<!-- 'update blog' form will be here -->

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post" enctype="multipart/form-data">
 
    <table class='table'>
        <tr>
        <td>Name</td>
            <td><input type='text' name='name' /></td>
        </tr>
 
        <tr>
        <td>Title</td>
            <td><input type='text' name='title'/></td>
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
            <td></td>
            <td>
                <button type="submit">Update</button>
            </td>
        </tr>
 
    </table>
</form>
<?php
include_once 'layout_footer.php';?>
<!-- post code will be here -->
