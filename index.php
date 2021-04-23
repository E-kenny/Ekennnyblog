<?php 
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include_once 'config/core.php';
// include database and object file
include_once 'config/database.php';
include_once 'objects/blogs.php';
include_once 'objects/categories.php';


  


// instantiate database and objects
$database = new Database();
$db = $database->getConnection();
$blog = new Blogs($db);
$categories = new Categories($db);
  
// query products
  

$stmt = $blog->readAll($from_record_num, $records_per_page);
$page_url = "index.php?";
$num = $stmt->rowCount();

$total_rows = $blog->countAll();

//page header
$page_title = "Blogs";
?>

<?php
include_once 'layout_header.php';
 


include_once "read_template.php";
//page_footer
include_once 'layout_footer.php';

?>