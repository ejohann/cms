<form action="" method="post">
  <div class="form-group">
    <label for="category_title">Edit Category</label>
      <?php
      
       $statement = mysqli_prepare($connection, "SELECT id, category_title FROM categories WHERE id = ? ");  
       if(isset($statement))
        {
          mysqli_stmt_bind_param($statement, 'i', $edit_category_id);
          mysqli_stmt_execute($statement);
          mysqli_stmt_bind_result($statement, $category_id, $category_title);    
        }
      
        while(mysqli_stmt_fetch($statement))
         {
           $edit_category_id = $category_id;
           $category_title = $category_title;
         }
         mysqli_stmt_close($statement);
        if(isset($_POST['update_category']))
          {
            $the_category_title = escape($_POST['edit_category_title']);   
            $statement_update = mysqli_prepare($connection, "UPDATE categories SET category_title = ? WHERE id  = ? ");
            if(isset($statement_update))
             {
               mysqli_stmt_bind_param($statement_update, 'si', $the_category_title, $edit_category_id);
               mysqli_stmt_execute($statement_update);    
             }
            
            confirm_query($statement_update);
            mysqli_stmt_close($statement_update);
            redirect("categories.php");
          }
      ?>                                   
    <input class="form-control"  type="text" value=<?php echo $category_title; ?> name="edit_category_title"></input>
  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="update_category" value="Update">
  </div>
</form> 