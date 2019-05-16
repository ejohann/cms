
<?php
 
   if(isset($_GET['edit']))
    {       
      $the_user_id = $_GET['edit'];
    
      $query = "SELECT * FROM users WHERE id = $the_user_id ";
      $select_user_by_id = mysqli_query($connection, $query);
     
      confirm_query($select_user_by_id);
       
     while($row = mysqli_fetch_assoc($select_user_by_id))
       {
        // $the_user_id = $row['id'];
         $the_username = $row['username'];
         $the_user_password = $row['user_password'];
         $the_user_firstname = $row['user_firstname'];
         $the_user_lastname = $row['user_lastname'];
         $the_user_email = $row['user_email'];
         $the_user_image = $row['user_image'];
         $the_user_role = $row['user_role'];
       }
    }
      
   if(isset($_POST['edit_user']))
    {      
       $user_firstname = $_POST['user_firstname'];
       $user_lastname = $_POST['user_lastname'];
       $username = $_POST['username'];
       $user_role = $_POST['user_role'];     
      // $post_image = $_FILES['post_image']['name'];
    //   $post_image_temp = $_FILES['post_image']['tmp_name'];
       $user_password = $_POST['user_password'];
       $user_email = $_POST['user_email'];
    //   $post_date = date('d-m-y');   
     //  move_uploaded_file($post_image_temp, "../images/$post_image");
      $query = "UPDATE users SET username = '{$username}' , user_password = '{$user_password}', user_firstname = '{$user_firstname}', user_lastname = '{$user_lastname}', user_email = '{$user_email}' , user_role = '{$user_role}' WHERE id = $the_user_id ";
 

       $update_user_query = mysqli_query($connection, $query);  
        confirm_query($update_user_query);
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
      <input type="password" class="form-control" value="<?php echo $the_user_password; ?>" name="user_password"></input>
  </div>

 
  
 <div class="form-group">
      <input type="submit" class="btn btn-primary" name="edit_user" value="Update User"></input>
  </div>
</form>