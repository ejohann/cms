   <form action="" method="post">
     <div class="form-group">
        <label for="category_title">Edit Category</label>
        <?php
         
             if(isset($_POST['edit']))
              {
                $the_category_title = $_POST['edit_category_title'];    
                $query = "UPDATE categories SET category_title = '{$the_category_title}' WHERE id = '{$edit_category_id }' ";
                $edit_query = mysqli_query($connection, $query);
                header("Location: categories.php");
                if(!$edit_query)
                 {
                   die("Category Query Failed " . mysqli_error($connection));  
                 }         
               }
             
            ?>                                   
        <input class="form-control"  type="text" name="edit_category_title"></input>                       
      </div>
      <div class="form-group">
         <input class="btn btn-primary" type="submit" name="edit" value="Update">
      </div>
    </form> 