<?php if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'Admin'){header("Location: ../../index.php"); exit;}?>


<?php
  if(isset($_GET['post_id']))
    {
      $the_post_id = escape($_GET['post_id']);
    }

  $select_post = mysqli_prepare($connection, "SELECT id, post_category_id, user_id, post_title, post_author, post_image, post_content, post_tags, post_status FROM posts WHERE id = ?");
  mysqli_stmt_bind_param($select_post, 'i', $the_post_id);
  mysqli_stmt_execute($select_post);
  confirm_query($select_post);
  mysqli_stmt_bind_result($select_post, $post_id, $post_category_id, $post_user_id, $post_title, $post_author, $post_image, $post_content, $post_tags, $post_status);
  mysqli_stmt_fetch($select_post);
  mysqli_stmt_close($select_post);

  if(isset($_POST['update_post']))
    {
      $post_title = escape($_POST['post_title']);
      $post_category_id = escape($_POST['post_category']);
      $post_author = escape($_POST['post_author']);
      $post_author_id = get_user_id($post_author);
      $post_status = escape($_POST['post_status']);
      $post_image = escape($_FILES['post_image']['name']);
      $post_image_temp = $_FILES['post_image']['tmp_name'];
      $post_tags = escape($_POST['post_tags']);
      $post_content = escape($_POST['post_content']);
      move_uploaded_file($post_image_temp, "../images/$post_image");       
     
      if(empty($post_image))
        {
          $select_image = mysqli_prepare($connection, "SELECT post_image FROM posts WHERE id = ? ");
          mysqli_stmt_bind_param($select_image, 'i', $the_post_id);
          mysqli_stmt_execute($select_image);
          confirm_query($select_image);
          mysqli_stmt_bind_result($select_image, $post_image);
          mysqli_stmt_fetch($select_image);
          mysqli_stmt_close($select_image);
        }
      
      $query = "UPDATE posts SET ";
      $query .= "post_title = '{$post_title}', ";
      $query .= "post_category_id = '{$post_category_id}', ";
        $query .= "user_id = '{$post_author_id}', ";
    //  $query .= "post_date = now(), ";
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
        $select_categories = mysqli_prepare($connection, "SELECT id, category_title FROM categories");
        mysqli_stmt_execute($select_categories);
        confirm_query($select_categories);
        mysqli_stmt_bind_result($select_categories, $category_id, $category_title);
        while(mysqli_stmt_fetch($select_categories))
          {
             if($category_id == $post_category_id)
             {
                 echo "<option selected value='{$category_id}'>{$category_title}</option>";
             }
            else
             {
                 echo "<option value='{$category_id}'>{$category_title}</option>";
             }  
          }
        mysqli_stmt_close($select_categories);
      ?>     
    </select>
  </div> 
   
    <div class="form-group">
    <label for="post_author">Post Author</label>
    <select name="post_author" id="post_author">
      <?php
         $select_users = mysqli_prepare($connection, "SELECT username FROM users");
         mysqli_stmt_execute($select_users);
         confirm_query($select_users);
         mysqli_stmt_bind_result($select_users, $username);
         while(mysqli_stmt_fetch($select_users))
          {
            if($post_author == $username)
             {
                echo "<option selected value='{$username}'>{$username}</option>";
             }
            else
             {
                echo "<option value='{$username}'>{$username}</option>";
             }
          }
         mysqli_stmt_close($select_users);
      ?>     
    </select>
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