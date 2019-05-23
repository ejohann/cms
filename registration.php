<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>

<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>
    
<?php

  if(isset($_POST['submit']))
   {
     $username = escape($_POST['username']);
     $user_email = escape($_POST['email']);
     $user_password = escape($_POST['password']);
     $user_role = "Subscriber";     
  
     $error = [
         'username' => '',
         'user_email' => '',
         'user_password' => ''
     ];  
       
      // validate username
      if(!username_exists($username))
       {
         $error['username'] = "This username already exists, please select another username";   
       }
      else if($username == '')
       {
         $error['username'] = "Username field cannot be empty";   
       }
      else if(strlen($username) < 4 )
       {
          $error['username'] = "Username needs to be longer that 3 characters";   
       }
      
      if(!email_exists($user_email))
       {
         $error['user_email'] = "This email address already exists, please select another email address or <a href='index.php'> login</a>";   
       }
      else if($user_email == '')
       {
         $error['user_email'] = "Email address field cannot be empty";   
       }
      
      if($user_password == '')
       {
         $error['user_password'] = "Password field cannot be empty";   
       }
      else if(strlen($user_password) < 7 )
        {
          $error['user_password'] = "Password should be longer than 6 characters";   
        }
       
       foreach($error as $key => $value)
        {
          if(empty($value))
           {
             unset($error[$key]);  
           } 
        }
      
      if(empty($error))
        {
          register_user($username, $user_password, $user_email, $user_role);  
        }
      
    /* if(!username_exists($username))
       {
         $message = "This username already exists, please select another username";   
       }
      
     else if(!email_exists($user_email))
      {
         $message = "This email address already exists, please select another email address or use forget password link"; 
     }
    else if(!empty($username) && !empty($user_email) && !empty($user_password))
       {
         $user_role = "Subscriber";     
         $user_password = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => 10));
         register_user($username, $user_password, $user_email, $user_role);
         $message = "Registration has been submitted successfully";       
       }
      else
       {
         $message = "Fields cannot be empty";   
       } */
   } 

?>                        

                        
<!-- Page Content -->
<div class="container">
  <section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input autocomplete="on" type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" value="<?php echo isset($username) ? $username : '' ?>">
                            <!-- Display username validation error -->
                            <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input autocomplete="on" type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" value="<?php echo isset($user_email) ? $user_email : '' ?>">
                            <!-- Display user email validation error -->
                            <p><?php echo isset($error['user_email']) ? $error['user_email'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                               <!-- Display user email validation error -->
                            <p><?php echo isset($error['user_password']) ? $error['user_password'] : '' ?></p>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
