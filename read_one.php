<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// get ID of the Blog to be edited
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
$user->id = $_SESSION['id'];


  
// read the details of blog to be edited
$blog->readOne();
$user->readOne();

// page headers
$page_title = "Read Blog";
include_once "layout_header.php";
 
// read blog button

echo "<div class='nav'>";
echo "<a href='index.php' class='read-anchor'>";
    echo '<button type="submit" class="btn btn-default">All Blogs</button>';
echo "</a>";
echo "</div>";
echo "<br>";
echo "<hr/>";
echo "<br>";
echo "<h2>{$blog->Tittle}   </h2>";
    echo "<div class='flex-head'>";
    echo "<br>";
            echo $blog->image ? "<img src='uploads/{$blog->image}'  />" : "No image found.";
            ;
            echo "<h4>By {$user->names}   </h4>";
            echo "<p class='date2'>created {$blog->CreationDate} </P>";
    echo  "</div>";

    echo "<div class='flex-body'>
                <p>$blog->description</p>
                
                
          </div>";

//page footer
 // echo "<p class='date1'>modified {$blog->UpdationDate} </P>";

include_once "layout_footer.php";

?>