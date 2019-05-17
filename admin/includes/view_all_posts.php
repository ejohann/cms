<?php
  if(isset($_POST['checkBoxArray']))
   {
      foreach($_POST['checkBoxArray'] as $postIdValue)
        {
         // echo $checkBoxValue;
         $bulk_options = $_POST['bulk_options'];
         
         switch($bulk_options)
           {
             case 'published':
               $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE id = {$postIdValue}";
               $update_to_published = mysqli_query($connection, $query);
               confirm_query($update_to_published);
             break;
                 
             case 'draft':
               $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE id = {$postIdValue}";
               $update_to_draft = mysqli_query($connection, $query);
               confirm_query($update_to_draft);
             break;
                 
             case 'delete':
               $query = "DELETE FROM posts WHERE id = $postIdValue";
               $delete_post = mysqli_query($connection, $query);
               confirm_query($delete_post);
             break;
                 
            case 'clone':
               $query = "SELECT * FROM posts WHERE id = $postIdValue";
               $select_post_by_id = mysqli_query($connection, $query);
               confirm_query($select_post_by_id);
               while($row_post = mysqli_fetch_array($select_post_by_id))
                 {
                   $post_title = $row_post['post_title'];
                   $post_category_id = $row_post['post_category_id'];
                   $post_date = $row_post['post_date'];
                   $post_author = $row_post['post_author'];
                   $post_status = $row_post['post_status'];
                   $post_image = $row_post['post_image'];
                   $post_tags = $row_post['post_tags'];
                   $post_content = $row_post['post_content'];
                   $post_comment_count = 0;
                 }
                $query = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
                $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_author}', '{$post_date}', '{$post_image}', '{$post_content}', '{$post_tags}', $post_comment_count, '{$post_status}' )";
                $copy_query = mysqli_query($connection, $query);
                 confirm_query($copy_query);
                
             break;
           
          }
          
        }
   }
?>


<form action="" method="post">

 <table class="table table-bordered table-hover">
  <div id="bulkOptionContainer" class="col-xs-4" style="padding: 0px;">
   <select class="form-control" name="bulk_options" id="">
       <option value="">Select Options</option>
       <option value="published">Publish</option>
       <option value="draft">Draft</option>
       <option value="delete">Delete</option>
       <option value="clone">Clone</option>
   </select>
  </div>
  <div class="col-xs-4"> 
     <input type="submit" name="submit" class="btn btn-success" value="Apply"></input>
     <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
  </div>  
   <thead>
    <tr>
      <th><input id="selectAllBoxes" type="checkbox"></th>
      <th>ID</th>
      <th>Author</th>
      <th>Title</th>
      <th>Category</th>
      <th>Status</th>
      <th>Image</th>
      <th>Tags</th>                             
      <th>Comments</th>
      <th>Date</th>
      <th>View</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $query = "SELECT * FROM posts";
      $select_all_posts = mysqli_query($connection, $query);
      while($row = mysqli_fetch_assoc($select_all_posts))
        {
          $post_id = $row['id'];
          $post_author = $row['post_author'];
          $post_title = $row['post_title'];
          $post_cateogry_id = $row['post_category_id'];
          $post_status = $row['post_status'];
          $post_image = $row['post_image'];
          $post_content = $row['post_content'];
          $post_tags = $row['post_tags'];
          $post_comment_count = $row['post_comment_count'];
          $post_date = $row['post_date'];
          echo "<tr>";
          
          ?>
          
          <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></input></td>
          
          <?php
          echo "<td>{$post_id}</td>";
          echo "<td>{$post_author}</td>";
          echo "<td>{$post_title}</td>";
          $query = "SELECT * FROM categories WHERE id= $post_cateogry_id";
          $select_category_by_id = mysqli_query($connection, $query);
          confirm_query( $select_category_by_id);
          while($row = mysqli_fetch_assoc($select_category_by_id))
            {
              $category_title = $row['category_title'];
              $category_id = $row['id'];
            }
          echo "<td>{$category_title}</td>";
          echo "<td>{$post_status}</td>";
          echo "<td><img width='100' src='../images/{$post_image }' alt='image'></img></td>";
          echo "<td>{$post_tags}</td>";
          echo "<td>{$post_comment_count}</td>";
          echo "<td>{$post_date}</td>";
          echo "<td><a href='../post.php?post_id={$post_id }'>View</a></td>";
          echo "<td><a href='posts.php?source=edit_post&post_id={$post_id }'>Edit</a></td>";
          echo "<td><a onClick= \"javascript: return confirm('Are you sure you want to delete this post?'); \" href='posts.php?delete={$post_id }'>Delete</a></td>";
          echo "</tr>";
        }
    ?>                  
  </tbody>
</table>

</form>

<?php
  if(isset($_GET['delete']))
    {
      $the_post_id = $_GET['delete'];
      $query = "DELETE FROM posts WHERE id = {$the_post_id} ";
      $delete_post_query = mysqli_query($connection, $query);
      confirm_query($delete_post_query);
      header("Location: posts.php");
    }
?>    