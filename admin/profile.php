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
            $username = $_SESSION['username'];   
            $query = "SELECT * FROM users WHERE username = '{$username}' ";   
            $select_user_profile = mysqli_query($connection, $query);    
            while($row = mysqli_fetch_array($select_user_profile))
             {
               $the_username = $row['username'];
               $the_user_id = $row['id'];
               $the_user_password = $row['user_password'];
               $the_user_firstname = $row['user_firstname'];
               $the_user_lastname = $row['user_lastname'];
               $the_user_email = $row['user_email'];
               $the_user_role = $row['user_role'];                   
             }
          }
       ?>
       <?php
         if(isset($_POST['update_profile']))
           {      
             $user_firstname = $_POST['user_firstname'];
             $user_lastname = $_POST['user_lastname'];
             $this_username = $_POST['username'];     
             // $post_image = $_FILES['post_image']['name'];
             // $post_image_temp = $_FILES['post_image']['tmp_name'];
             $user_password = $_POST['user_password'];
             $user_email = $_POST['user_email'];
             // $post_date = date('d-m-y');   
             // move_uploaded_file($post_image_temp, "../images/$post_image");
      
             if(!empty($user_password))
              {
                if($the_user_password != $user_password)
                  {
                    $user_password = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => 10));
                    $query = "UPDATE users SET username = '{$username}', user_password = '{$user_password}', user_firstname = '{$user_firstname}', user_lastname = '{$user_lastname}', user_email = '{$user_email}' WHERE id = $the_user_id ";
                    $update_user_query = mysqli_query($connection, $query);  
                    confirm_query($update_user_query);  
                    echo "User {$username} Updated: " . "<a href='users.php'>View Users</a>";
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
             <h1 class="page-header">User Profile<small><?php echo $username; ?></small></h1>               
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
                 <label for="username">Username</label>
                 <input type="text" value="<?php echo  $the_username; ?>" class="form-control" name="username"></input>
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