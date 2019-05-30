<?php if(!isset($_SESSION['user_role'])){header("Location: ../../index.php"); exit;}?>
 
 
 <?php
  if(isset($_POST['create_user']))
    {      
      $user_firstname = escape($_POST['user_firstname']);
      $user_lastname = escape($_POST['user_lastname']);
      $username = escape($_POST['username']);
      $user_role = escape($_POST['user_role']);
      // $post_image = $_FILES['post_image']['name'];
      // $post_image_temp = $_FILES['post_image']['tmp_name'];
      $user_password = escape($_POST['user_password']);
      $user_email = escape($_POST['user_email']);
      // $post_date = date('d-m-y');
      $user_password = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => 10));       
      //  move_uploaded_file($post_image_temp, "../images/$post_image");
      $query = "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_role) ";
      $query .= "VALUES('{$username}', '{$user_password}', '{$user_firstname}', '{$user_lastname}', '{$user_email}', '{$user_role}')";
      $create_user_query = mysqli_query($connection, $query);  
      confirm_query($create_user_query);
      echo "User {$username} Created: " . "<a href='users.php'>View Users</a>";
    }
  
    ?>

<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="user_firstname">First Name</label>
    <input type="text" class="form-control" name="user_firstname"></input>
  </div>
  <div class="form-group">
    <label for="user_lastname">Last Name</label>
    <input type="text" class="form-control" name="user_lastname"></input>
  </div>
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="username"></input>
  </div>
  <div class="form-group">
    <label for="user_role">User Role</label>
    <select name="user_role" id="">
      <option value="Subscriber">Select Options</option>
      <option value="Admin">Admin</option>
      <option value="Subscriber">Subscriber</option>
    </select>
  </div>
  <div class="form-group">
    <label for="user_email">Email</label>
    <input type="email" class="form-control" name="user_email"></input>
  </div>
  <div class="form-group">
    <label for="user_password">Password</label>
    <input type="password" class="form-control" name="user_password"></input>
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="create_user" value="Add User"></input>
  </div>
</form>