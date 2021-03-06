 <?php if(!isset($_SESSION['user_role'])){header("Location: ../../index.php"); exit;}?>

 <?php
  if(isset($_GET['edit']))
    {       
      $the_user_id = escape($_GET['edit']);
      // get the user details from db
      $select_user = mysqli_prepare($connection, "SELECT username, user_password, user_firstname, user_lastname, user_email, user_role FROM users WHERE id = ? ");
      mysqli_stmt_bind_param($select_user, 'i', $the_user_id);
      mysqli_stmt_execute($select_user);
      confirm_query($select_user);
      mysqli_stmt_store_result($select_user);
      mysqli_stmt_bind_result($select_user, $the_username, $the_user_password, $the_user_firstname, $the_user_lastname, $the_user_email, $the_user_role);
      mysqli_stmt_fetch($select_user);
      mysqli_stmt_close($select_user);
      
   if(isset($_POST['edit_user']))
    {      
      $user_firstname = escape($_POST['user_firstname']);
      $user_lastname = escape($_POST['user_lastname']);
      $username = escape($_POST['username']);
      $user_role = escape($_POST['user_role']);     
      // $post_image = $_FILES['post_image']['name'];
      //   $post_image_temp = $_FILES['post_image']['tmp_name'];
      $user_password = escape($_POST['user_password']);
      $user_email = escape($_POST['user_email']);  
      //  move_uploaded_file($post_image_temp, "../images/$post_image");
      if(!empty($user_password))
        {
          if($the_user_password != $user_password)
            {
              $user_password = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => 10));
              $update_password = mysqli_prepare($connection, "UPDATE users SET username = ?, user_password = ?, user_firstname = ?, user_lastname = ?, user_email = ?, user_role = ? WHERE id = ? ");
              mysqli_stmt_bind_param($update_password, 'ssssssi', $username, $user_password, $user_firstname, $user_lastname, $user_email, $user_role, $the_user_id);
              mysqli_stmt_execute($update_password);
              confirm_query($update_password);
              mysqli_stmt_close($update_password);
              echo "{$username} details has been updated: " . "<a href='users.php'>View Users</a>";
            }
        }
       else
        {
          $update_user = mysqli_prepare($connection, "UPDATE users SET username = ?, user_firstname = ?, user_lastname = ?, user_email = ?, user_role = ? WHERE id = ? ");
          mysqli_stmt_bind_param($update_user, 'sssssi', $username, $user_firstname, $user_lastname, $user_email, $user_role, $the_user_id);
          mysqli_stmt_execute($update_user);
          confirm_query($update_user);
          mysqli_stmt_close($update_user);
          echo "{$username} details has been updated: " . "<a href='users.php'>View Users</a>";
       }
    }
  }
 else
  {
    header("LOCATION: ../index.php");   
  }
?>

<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="user_firstname">First Name</label>
    <input type="text" class="form-control" value="<?php echo $the_user_firstname; ?>"  name="user_firstname"></input>
  </div>
  <div class="form-group">
    <label for="user_lastname">Last Name</label>
    <input type="text" class="form-control" value="<?php echo $the_user_lastname; ?>" name="user_lastname"></input>
  </div>
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" value="<?php echo $the_username; ?>" class="form-control" name="username"></input>
  </div>
  <div class="form-group">
    <label for="user_role">User Role</label>
    <select name="user_role" id="">
      <option value="<?php echo $the_user_role; ?>"><?php echo $the_user_role; ?></option>
      <?php
        if($the_user_role == 'Admin')
          {   
            echo " <option value='Subscriber'>Subscriber</option>";
          }
        else
          {
            echo "<option value='Admin'>Admin</option>";
          }
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="user_email">Email</label>
     <input type="email" class="form-control" value="<?php echo $the_user_email; ?>" name="user_email"></input>
  </div>
  <div class="form-group">
    <label for="user_password">Password</label>
    <input autocomplete="off" type="password" class="form-control" value="" name="user_password"></input>
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="edit_user" value="Update User"></input>
  </div>
</form>