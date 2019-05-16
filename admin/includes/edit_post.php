<?php
  if(isset($_GET['post_id']))
    {
      $the_post_id = $_GET['post_id'];
    }

  $query = "SELECT * FROM posts WHERE id = '{$the_post_id}}'";
  $select_post_by_id = mysqli_query($connection, $query); 
  confirm_query($select_post_by_id);
  while($row = mysqli_fetch_assoc($select_post_by_id))
    {
      $post_id = $row['id'];
      $post_author = $row['post_author'];
      $post_title = $row['post_title'];
      $post_category_id = $row['post_category_id'];
      $post_status = $row['post_status'];
      $post_image = $row['post_image'];
      $post_content = $row['post_content'];
      $post_tags = $row['post_tags'];
      $post_comment_count = $row['post_comment_count'];
      $post_date = $row['post_date'];
    }

  if(isset($_POST['update_post']))
    {
      $post_title = $_POST['post_title'];
      $post_category_id = $_POST['post_category'];
      $post_author = $_POST['post_author'];
      $post_status = $_POST['post_status'];
      $post_image = $_FILES['post_image']['name'];
      $post_image_temp = $_FILES['post_image']['tmp_name'];
      $post_tags = $_POST['post_tags'];
      $post_content = $_POST['post_content'];
      move_uploaded_file($post_image_temp, "../images/$post_image");       
      if(empty($post_image))
        {
          $query = "SELECT * FROM posts WHERE id = $the_post_id ";
          $select_image_query = mysqli_query($connection, $query);
          confirm_query($select_image_query);
          while($row = mysqli_fetch_array($select_image_query))
            { 
              $post_image = $row['post_image'];    
            }
        }
      $query = "UPDATE posts SET ";
      $query .= "post_title = '{$post_title}', ";
      $query .= "post_category_id = '{$post_category_id}', ";
      $query .= "post_date = now(), ";
      $query .= "post_author = '{$post_author}', ";
      $query .= "post_status = '{$post_status}', ";
      $query .= "post_tags = '{$post_tags}', ";
      $query .= "post_content = '{$post_content}', ";
      $query .= "post_image = '{$post_image}' ";
      $query .= "WHERE id= {$the_post_id} ";
      $update_post_query = mysqli_query($connection, $query);
      confirm_query($update_post_query); 
      
      echo "<p class='bg-success'>Post Edited: <a href='../post.php?post_id={$the_post_id}'>View Post </a> or <a href='./posts.php'>Edit Other Posts</a></p>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="post_title">Post Title</label>
    <input type="text" value="<?php echo $post_title; ?>" class="form-control" name="post_title"></input>
  </div>
  <div class="form-group">
    <label for="post_category">Post Category</label>
    <select name="post_category" id="post_category">
      <?php
        $query = "SELECT * FROM categories";
        $select_category = mysqli_query($connection, $query);
        confirm_query($select_category);
        while($row = mysqli_fetch_assoc($select_category))
          { 
            $category_title = $row['category_title'];
            $category_id = $row['id'];
            echo "<option value='{$category_id}'>{$category_title}</option>";
          }
      ?>     
    </select>
  </div>
  <div class="form-group">
    <label for="post_author">Post Author</label>
    <input type="text" value="<?php echo $post_author; ?>" class="form-control" name="post_author"></input>
  </div>
  <div class="form-group">
    <label for="post_status">Post Status</label>
    <select name="post_status" id="">
      <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
      <?php 
        if($post_status == 'draft')
          {
            echo "<option value='published'>Published</option>";     
          }
        else
          {
            echo "<option value='draft'>Draft</option>";                
          }
      ?>
    </select>
  </div>
  <div class="form-group">
    <img src="../images/<?php echo $post_image; ?>" width="100px"></img>
    <input type="file" class="form-control" name="post_image"></input>
  </div>
  <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input type="text" value="<?php echo $post_tags; ?>" class="form-control" name="post_tags"></input>
  </div>
  <div class="form-group">
    <label for="post_content">Post Content</label>
    <textarea class="form-control" id="body" cols="30" rows="10" name="post_content"><?php echo $post_content; ?></textarea>
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="update_post" value="Update Post"></input>
  </div>
</form>