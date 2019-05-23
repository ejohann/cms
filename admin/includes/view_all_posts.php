<?php
  include("delete_modal.php");
?>

<?php
  if(isset($_POST['checkBoxArray']))
   {
      foreach($_POST['checkBoxArray'] as $postIdValue)
        {
         $bulk_options = escape($_POST['bulk_options']);
         $postIdValue = escape($postIdValue);
          
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
                   $post_title = escape($row_post['post_title']);
                   $post_category_id = escape($row_post['post_category_id']);
                   $post_date = escape($row_post['post_date']);
                   $post_author = escape($row_post['post_author']);
                   $post_status = escape($row_post['post_status']);
                   $post_image = escape($row_post['post_image']);
                   $post_tags = escape($row_post['post_tags']);
                   $post_content = escape($row_post['post_content']);
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
      <th>Views</th>
      <th>Date</th>
      <th>View</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $query = "SELECT posts.id as p_id, posts.post_category_id, posts.post_title, posts.post_author, posts.post_date, posts.post_image, posts.post_content, posts.post_tags, posts.post_status, posts.post_views_count, categories.id as c_id, categories.category_title FROM posts LEFT JOIN categories ON posts.post_category_id = categories.id ORDER BY p_id DESC";
      $select_all_posts = mysqli_query($connection, $query);
      while($row = mysqli_fetch_assoc($select_all_posts))
        {
          $post_id = escape($row['p_id']);
          $post_author = $row['post_author'];
          $post_title = $row['post_title'];
          $post_cateogry_id = escape($row['post_category_id']);
          $post_status = $row['post_status'];
          $post_image = $row['post_image'];
          $post_content = $row['post_content'];
          $post_tags = $row['post_tags'];
          $post_date = $row['post_date'];
          $post_views_count = $row['post_views_count'];
          $category_title = $row['category_title'];
          $category_id = $row['c_id'];
          echo "<tr>"; 
          ?>
          
          <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></input></td>
          
          <?php
          echo "<td>{$post_id}</td>";
          echo "<td>{$post_author}</td>";
          echo "<td>{$post_title}</td>";
          echo "<td>{$category_title}</td>";
          echo "<td>{$post_status}</td>";
          echo "<td><img width='100' src='../images/{$post_image}' alt='image'></img></td>";
          echo "<td>{$post_tags}</td>";
          $query_comment = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
          $select_comment_by_post_id = mysqli_query($connection, $query_comment);
          confirm_query($select_comment_by_post_id);
          $row = mysqli_fetch_array($select_comment_by_post_id);
          $post_comment_count = mysqli_num_rows($select_comment_by_post_id);   
          echo "<td><a href='post_comments.php?comment_post_id={$post_id}'>{$post_comment_count}</a></td>";
          echo "<td><a onClick= \"javascript: return confirm('Are you sure you want to reset this value?'); \" href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";
          echo "<td>{$post_date}</td>";
          echo "<td><a class='btn btn-primary' href='../post.php?post_id={$post_id}'>View</a></td>";
          echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&post_id={$post_id}'>Edit</a></td>";
        ?>
      <form method="post">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>"></input>
            <td><input rel="<?php echo $post_id; ?>" class="btn btn-danger del_link" type="submit" name="delete" value="Delete"> </input></td>             
         </form>
        
        <?php  
        //  echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
          echo "</tr>";
        }
    ?>                  
  </tbody>
</table>

</form>

<?php
  if(isset($_POST['delete']))
    { 
      if(isset($_SESSION['user_role']))
       {
        if($_SESSION['user_role'] == "Admin")
          {
            $the_post_id = $_POST['post_id'];
            $query = "DELETE FROM posts WHERE id = {$the_post_id} ";
            $delete_post_query = mysqli_query($connection, $query);
            confirm_query($delete_post_query);
            header("Location: posts.php");
          }
        else
          {    
           header("Location: index.php");
          }
        }
      else
        {
          header("Location: ../index.php");
      }
    }

   if(isset($_GET['reset']))
    { 
      if(isset($_SESSION['user_role']))
        {
          if($_SESSION['user_role'] == "Admin")
            {
              $the_post_id = escape($_GET['reset']);
              $reset_value = 0;
              $query = "UPDATE posts SET post_views_count = $reset_value WHERE id = {$the_post_id} ";
              $reset_post_query = mysqli_query($connection, $query);
              confirm_query($reset_post_query);
              header("Location: posts.php");
            }
          else
           {    
             header("Location: index.php");
           }
        }
      else
        {
          header("Location: ../index.php");
      }
    }
?>    

<script>
$(document).ready(function(){
    $(".del_link").on('click', function(e){
      e.preventDefault();
      var post_id = $(this).attr("rel");   
      $(".modal_delete_link").val(post_id);  
      $(".modal-body").html("<h6>Are you sure you want to delete this post?  " + post_id + "</h6>");    
      $("#myModal").modal('show');   
    });
});  
</script>