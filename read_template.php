
<?php

// search form
echo "<form role='search' action='search.php'>";
    
        $search_value=isset($search_term) ? "value='{$search_term}'" : "";
       echo "<div class='form-group'>";
            echo "<div class='col-sm-3'>";
                echo "<input type='text' class='form-control' placeholder='Type blog name or description...' name='s' id='srch-term'  {$search_value} />";
            echo "</div>";
       echo "</div>";


       echo "<div class='form-group'>";
            echo "<div class='col-sm-2'>";
                echo "<button type='submit' class='btn btn-default'>Search</button>";
            echo "</div>";
        echo "</div>";     

echo "</form>";
     
echo    "<div class='row'>
                                    <div class='col-sm-2 style='margin:10px'>
                                        <a href='create_blog.php' >
                                        <button> Create </button>
                                        </a>
                                        
                                    </div>
                                  
                                    <div class='col-sm-1' style='margin:3px'>
                                        <a href='logout.php' >
                                            <button> Logout </button>
                                        </a>
                                    </div>
                            </div>";
                
 echo "<hr/>";
 
//show data from database
// display the products if there are any
echo "<div class='row'>";
                if($total_rows>0){
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            
                        extract($row);
                                    echo "<div class='flex'>";
                                        echo "<h3>$Tittle   </h3>";
                                        // echo "<h5>By $name   </h5>";
                                        echo "<p class='date'>created $CreationDate </P>";
                                        echo "<div class='flex-anchor'>";
                                        // read one, edit and delete 
                            
                                                echo "<div>
                                                   
                                                    <a href='delete_blog.php?id={$id}' >
                                                    <button>Delete</button>
                                                    </a>
                                                    </div>
                                
                                        
                                                <div>
                                                    <a href='read_one.php?id={$id}'>
                                                    <button>Read</button>
                                                    </a>
                                                </div>";
                                            echo "</div >";



                                    echo  "</div>";

                    }
        
        echo "</div>";
echo "</div>";
  
    // paging buttons 
    include_once 'paging.php';

}
// tell the user there are no blog
else{
    echo "<h3>No Blog found.</h3>";
}

?>