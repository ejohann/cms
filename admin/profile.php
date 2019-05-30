<?php include "includes/admin_header.php"; ?>
   <div id="wrapper">
     <!-- Navigation -->
     <?php include "includes/admin_navigation.php"; ?>           
     <div id="page-wrapper">    
       <?php
         if(!isset($_SESSION['username']))
           {
             header("Location: ../index.php");
           }
         else    
          {      
            $username = escape($_SESSION['username']);   
            $select_user = mysqli_prepare($connection, "SELECT id, username, user_password, user_firstname, user_lastname, user_email, user_role FROM users WHERE username = ? ");
            mysqli_stmt_bind_param($select_user, 's', $username);
            mysqli_stmt_execute($select_user);
            confirm_query($select_user);
            mysqli_stmt_store_result($select_user);
            mysqli_stmt_bind_result($select_user, $the_user_id, $the_username, $the_user_password, $the_user_firstname, $the_user_lastname, $the_user_email, $the_user_role);
            mysqli_stmt_fetch($select_user);
            mysqli_stmt_close($select_user);
          }
       ?>
       <?php
         if(isset($_POST['update_profile']))
           {      
             $user_firstname = escape($_POST['user_firstname']);
             $user_lastname = escape($_POST['user_lastname']);
             $this_username = escape($_POST['username']);     
             // $post_image = $_FILES['post_image']['name'];
             // $post_image_temp = $_FILES['post_image']['tmp_name'];
             $user_password = escape($_POST['user_password']);
             $user_email = escape($_POST['user_email']);
             // move_uploaded_file($post_image_temp, "../images/$post_image");
      
             if(!empty($user_password))
              {
                if($the_user_password != $user_password)
                  {
                    $user_password = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => 10));
                    $update_password = mysqli_prepare($connection, "UPDATE users SET username = ?, user_password = ?, user_firstname = ?, user_lastname = ?, user_email = ? WHERE id = ? ");
                    mysqli_stmt_bind_param($update_password, 'sssssi', $username, $user_password, $user_firstname, $user_lastname, $user_email, $the_user_id);
                    mysqli_stmt_execute($update_password);
                    confirm_query($update_password);
                    mysqli_stmt_close($update_password);
                    echo "{$username} profile updated! " . "Please <a href='../includes/logout.php'>logout</a> and log back in to see changes!";
                  }
              }
            else
             {
                $query = "UPDATE users SET username = '{$this_username}', user_firstname = '{$user_firstname}', user_lastname = '{$user_lastname}', user_email = '{$user_email}' WHERE username = '{$username}' ";
                $update_profile_query = mysqli_query($connection, $query);  
                confirm_query($update_profile_query);
                echo "User {$username} Profile Updated: " . "<a href='users.php'>View Users</a>";
             }
           }
       ?>
    
       <div class="container-fluid">
         <!-- Page Heading -->
         <div class="row">
           <div class="col-lg-12">
             <h1 class="page-header">User Profile <small><?php echo $username; ?></small></h1>               
             <form action="" method="post" enctype="multipart/form-data">
               <div class="form-group">
                 <label for="user_firstname">First Name</label>
                 <input type="text" class="form-control" value="<?php echo  $the_user_firstname; ?>"  name="user_firstname"></input>
               </div>
               <div class="form-group">
                 <label for="user_lastname">Last Name</label>
                 <input type="text" class="form-control" value="<?php echo  $the_user_lastname; ?>" name="user_lastname"></input>
               </div>
               <div class="form-group">
                   <label for="username">Username <small><i>(cannot change username)</i></small></label>
                 <input readonly="readonly" type="text" value="<?php echo  $the_username; ?>" class="form-control" name="username"></input>
               </div>
               <div class="form-group">
                 <label for="user_email">Email</label>
                 <input type="email" class="form-control" value="<?php echo  $the_user_email; ?>" name="user_email"></input>
               </div>
               <div class="form-group">
                 <label for="user_password">Password</label>
                 <input autocomplete="off" type="password" class="form-control" value="" name="user_password"></input>
               </div>
               <div class="form-group">
                 <input type="submit" class="btn btn-primary" name="update_profile" value="Update Profile"></input>
               </div>
             </form>
           </div>
         </div><!-- /.row -->
       </div><!-- /.container-fluid -->
     </div><!-- /#page-wrapper -->
   </div><!-- /#wrapper -->

<?php include "includes/admin_footer.php"; ?>