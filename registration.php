<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>
    
<?php

  if(isset($_POST['submit']))
   {
     $username = mysqli_real_escape_string($connection, $_POST['username']);
     $user_email = mysqli_real_escape_string($connection, $_POST['email']);
     $user_password = mysqli_real_escape_string($connection, $_POST['password']);
     $query = "SELECT random_salt FROM users";
     $select_random_salt_query = mysqli_query($connection, $query);
     if(!$select_random_salt_query)
      { 
         die("QUERY FAILED" . mysqli_error($connection));
      }
     while($row = mysqli_fetch_assoc($select_random_salt_query))
      {
        echo $random_salt = $row['random_salt'];
     }
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
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
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
