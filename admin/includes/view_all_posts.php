<?php if(!isset($_SESSION['user_role'])){header("Location: ../../index.php"); exit;}?>
 
<?php
  include("delete_modal.php");
?>

<?php
 // set a user is admin variable
  $is_admin = null;
  if(is_admin(get_username()))
   {
     $is_admin = true;
   }
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
      // get all posts
      $select_posts = mysqli_prepare($connection, "SELECT posts.id, posts.post_category_id, posts.post_title, posts.post_author, posts.post_date, posts.post_image, posts.post_content, posts.post_tags, posts.post_status, posts.post_views_count, categories.id, categories.category_title FROM posts LEFT JOIN categories ON posts.post_category_id = categories.id ORDER BY posts.id DESC" );
      mysqli_stmt_execute($select_posts);
      mysqli_stmt_store_result($select_posts);
      confirm_query($select_posts);
      mysqli_stmt_bind_result($select_posts, $post_id, $post_category_id, $post_title, $post_author, $post_date, $post_image, $post_content, $post_tags, $post_status, $post_views_count, $category_id, $category_title);
      
      while(mysqli_stmt_fetch($select_posts))
       {
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
          
          // post comment count
          $select_comment = mysqli_prepare($connection, "SELECT id FROM comments WHERE comment_post_id = ? ");
          mysqli_stmt_bind_param($select_comment, 'i', $post_id);
          mysqli_stmt_execute($select_comment);
          confirm_query($select_comment);
          mysqli_stmt_store_result($select_comment);
          $post_comment_count = mysqli_stmt_num_rows($select_comment); 
          mysqli_stmt_close($select_comment);
            
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
          echo "</tr>";
        } // end while there is post
       // close the connection
      mysqli_stmt_close($select_posts);
    ?>                  
  </tbody>
</table>

</form>

<?php
 // delete single post
  if(isset($_POST['delete_item']))
    { 
      if(is_admin(get_username()))
       {
          $the_post_id = escape($_POST['delete_item']);
          $delete_post = mysqli_prepare($connection, "DELETE FROM posts WHERE id = ? ");
          mysqli_stmt_bind_param($delete_post, 'i', $the_post_id);
          mysqli_stmt_execute($delete_post);
          confirm_query($delete_post);
          mysqli_stmt_close($delete_post);
          redirect("posts.php");
        }
      else
        {
          redirect("../index.php");
        }
    }

  //reset post views
   if(isset($_GET['reset']))
    { 
      if(is_admin(get_username()))
        {
          $the_post_id = escape($_GET['reset']);
          $reset_value = 0;
          $reset_views = mysqli_prepare($connection, "UPDATE posts SET post_views_count = ? WHERE id = ?");
          mysqli_stmt_bind_param($reset_views, 'ii', $reset_value, $the_post_id);
          mysqli_stmt_execute($reset_views);
          confirm_query($reset_views);
          mysqli_stmt_close($reset_views);
          redirect("posts.php");
        }
      else
        {
          redirect("../index.php");
        }
    }
?>    

<script>
$(document).ready(function(){
    $(".del_link").on('click', function(e){
      e.preventDefault();
      var post_id = $(this).attr("rel");   
      $(".modal_delete_link").val(post_id);  
      $(".modal-body").html("<h6>Are you sure you want to delete this post ID  " + post_id + "</h6>");    
      $("#myModal").modal('show');   
    });
});  
</script>