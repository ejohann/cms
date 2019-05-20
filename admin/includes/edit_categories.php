<form action="" method="post">
  <div class="form-group">
    <label for="category_title">Edit Category</label>
      <?php
        $query_category = "SELECT * FROM categories WHERE id = $edit_category_id";
        $select_category_by_id = mysqli_query($connection, $query_category);
        confirm_query($select_category_by_id); 
        $row = mysqli_fetch_array($select_category_by_id);
        $category_title = $row['category_title'];
        if(isset($_POST['edit']))
          {
            $the_category_title = escape($_POST['edit_category_title']);    
            $query = "UPDATE categories SET category_title = '{$the_category_title}' WHERE id = '{$edit_category_id }' ";
            $edit_query = mysqli_query($connection, $query);
            header("Location: categories.php");
            if(!$edit_query)
              {
                die("Category Query Failed " . mysqli_error($connection));  
              }         
          }
      ?>                                   
    <input class="form-control"  type="text" value=<?php echo $category_title; ?> name="edit_category_title"></input>
  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="edit" value="Update">
  </div>
</form> 