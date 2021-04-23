
<?php

// search form
echo "<form role='search' action='search.php'>";
    echo "<div>";
        $search_value=isset($search_term) ? "value='{$search_term}'" : "";
        echo "<input type='text' class='form-control' placeholder='Type blog name or description...' name='s' id='srch-term' required {$search_value} />";
        echo "<div class='input-group-btn'>";
            echo "<button type='submit'>Search</button>";
        echo "</div>";
    echo "</div>";
echo "</form>";


echo "<div class='nav'>
        <div class='col-sm-offset-8 col-sm-4'>
            <a href='create_blog.php' class='btn btn-default'>Create-Blog</a>
        </div>
        
        <div class='col-sm-offset-8 col-sm-8'>
            <a href='logout.php' class='btn btn-default'>Logout</a>
        </div>
        
        </div>";
 echo "<hr/>";
//show data from database
// display the products if there are any
echo "<div class='grid-layout'>";
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
                                                    Delete
                                                    </a>
                                                    </div>
                                
                                        
                                                <div>
                                                    <a href='read_one.php?id={$id}'>
                                                    Read
                                                    </a>
                                                </div>";
                                            echo "</div >";



                                    echo  "</div>";

                    }
        
        echo "</div>";
  
    // paging buttons 
    include_once 'paging.php';

}
// tell the user there are no blog
else{
    echo "<h1>No Blog found.</h1>";
}
?>