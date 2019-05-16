<?php
  
 
  
  function confirm_query($query_result)
   {
     global $connection;
     if(!$query_result)
       {
         die("Post Query Failed " . mysqli_error($connection));   
       }  
   }



function insert_categories()
   {
       global $connection;
      if(isset($_POST['submit']))
       {
         $category_title = $_POST['category_title'];
         if($category_title == "" || empty($category_title))
          {
            echo "Category field cannot be empty";   
          }
         else
          {
            $query = "INSERT INTO categories(category_title) ";
            $query .= "VALUE('{$category_title}')";                         $create_category_query = mysqli_query($connection, $query);
            if(!$create_category_query)
             {
              die("Category Query Failed " . mysqli_error($connection));   
             }
           }
      }                      
   }


  function add_categories_form()
   {
     echo "  
      <form action='' method='post'>
                            <div class='form-group'>
                              <label for='category_title'>Add Category</label>
                              <input class='form-control' type='text' name='category_title'></input>          
                            </div>
                            <div class='form-group'>
                               <input class='btn btn-primary' type='submit' name='submit' value='Add Category'>
                            </div>
                          </form> 
        ";
   
   }
  
  function delete_categories()
   {
      global $connection; 
      if(isset($_GET['delete']))
        {
          $delete_category_id = $_GET['delete'];
          $query = "DELETE FROM categories WHERE id = {$delete_category_id}";
          $delete_query = mysqli_query($connection, $query);
          header("Location: categories.php");            
       }
  }
  
 
?>