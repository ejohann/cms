<?php
  if(isset($_POST['create_post']))
    {      
      $post_title = escape($_POST['post_title']);
      $post_category_id = escape($_POST['post_category_id']);
      $post_author = escape($_POST['post_author']);
      $post_status = escape($_POST['post_status']);
      $post_image = escape($_FILES['post_image']['name']);
      $post_image_temp = $_FILES['post_image']['tmp_name'];
      $post_tags = escape($_POST['post_tags']);
      $post_content = escape($_POST['post_content']);
      $post_date = date('d-m-y');
      $post_comment_count = 0;
             
      move_uploaded_file($post_image_temp, "../images/$post_image");
    
      $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
      $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_author}', '{$post_date}', '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_comment_count}', '{$post_status}')";
      $create_post_query = mysqli_query($connection, $query);  
      confirm_query($create_post_query);
      
      $post_id = mysqli_insert_id($connection);
      
      echo "<p class='bg-success'>Post Created: <a href='../post.php?post_id={$post_id}'>View Post </a> or <a href='./posts.php'>Modify Other Posts</a></p>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="post_title">Post Title</label>
    <input type="text" class="form-control" name="post_title"></input>
  </div>
  <div class="form-group">
    <label for="post_category">Post Category</label>
    <select name="post_category_id" id="post_category_id">
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
    <select name="post_author" id="post_author">
      <option value="<?php echo $_SESSION['username']; ?>">Select Author</option>
      <?php
        $query = "SELECT * FROM users";
        $select_author = mysqli_query($connection, $query);
        confirm_query($select_author);
        while($row = mysqli_fetch_assoc($select_author))
          {
            $username = $row['username'];
            $user_id = $row['id'];
            echo "<option value='{$username}'>{$username}</option>";
          }
      ?>     
    </select>
  </div>
  
  <div class="form-group">
    <label for="post_status">Post Status</label>
    <select name="post_status" id="">
      <option value="draft">Select Option</option>
      <option value='draft'>Draft</option>
      <option value='published'>Published</option>                  
    </select>
  </div>
  <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" class="form-control" name="post_image"></input>
  </div>
  <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input type="text" class="form-control" name="post_tags"></input>
  </div>
  <div class="form-group">
    <label for="post_content">Post Content</label>
    <textarea class="form-control" id="body" cols="30" rows="50" name="post_content"></textarea>
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post"></input>
  </div>
</form>