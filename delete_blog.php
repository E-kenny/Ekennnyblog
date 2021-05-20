<?php

 $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

 $page_title="delete blog";
 include_once 'layout_header.php';

 echo "<div class='nav'>
           <a href='index.php' class='btn'><button>Blogs</button></a>
      </div>";


// check if value was posted
if(isset($_GET['id'])){
 
    // include database and object file
    include_once 'config/database.php';
    include_once 'objects/blogs.php';
    include_once 'objects/users.php';
    include_once 'objects/categories.php';
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
 
    // prepare product object
    $blog = new Blogs($db);
     
    // set product id to be deleted
    $blog->id = $_GET['id'];
     
    // delete the product
    if($blog->delete()){
        echo "<h3>Blog was deleted!</h3>";
    }
     
    // if unable to delete the product
    else{
        echo "<h3>Unable to delete object!</h3>";
    }
}

include_once 'layout_footer.php';




?>